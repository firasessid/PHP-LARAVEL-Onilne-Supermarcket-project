import numpy as np
from scipy.sparse.linalg import svds
import json
import sys

def generate_recommendations(user_id, interactions):
    # Créer la matrice utilisateur-produit
    users = list(set([i['user_id'] for i in interactions]))
    products = list(set([i['product_id'] for i in interactions]))

    user_index = {u: i for i, u in enumerate(users)}
    product_index = {p: i for i, p in enumerate(products)}

    matrix = np.zeros((len(users), len(products)))

    for interaction in interactions:
        user = user_index.get(interaction['user_id'])
        product = product_index.get(interaction['product_id'])
        if user is not None and product is not None:
            matrix[user][product] = interaction['interaction_score']

    # Appliquer SVD
    try:
        U, sigma, Vt = svds(matrix, k=min(matrix.shape) - 1)
    except ValueError:
        return []  # Si la matrice est trop petite, retourner une liste vide

    sigma = np.diag(sigma)
    predicted_matrix = np.dot(np.dot(U, sigma), Vt)

    # Générer des recommandations pour l'utilisateur
    user_idx = user_index.get(user_id)
    if user_idx is None:
        return []  # Si l'utilisateur n'existe pas, retourner une liste vide

    user_predictions = predicted_matrix[user_idx]
    recommended_products = [
        products[i] for i in np.argsort(user_predictions)[::-1]
        if products[i] not in [i['product_id'] for i in interactions if i['user_id'] == user_id]
    ]

    return recommended_products[:5]  # Retourner les 5 meilleures recommandations

if __name__ == "__main__":
    # Vérifier si les arguments sont fournis
    if len(sys.argv) < 3:
        print("Usage: python recommend.py <user_id> <interactions_file>")
        sys.exit(1)

    # Récupérer les arguments
    user_id = int(sys.argv[1])
    interactions_file = sys.argv[2]

    # Charger les interactions depuis le fichier
    try:
        with open(interactions_file, 'r') as f:
            interactions = json.load(f)
    except FileNotFoundError:
        print(f"Erreur : Le fichier '{interactions_file}' n'a pas été trouvé.")
        sys.exit(1)

    # Générer les recommandations
    recommendations = generate_recommendations(user_id, interactions)

    # Afficher les résultats
    print(json.dumps(recommendations))