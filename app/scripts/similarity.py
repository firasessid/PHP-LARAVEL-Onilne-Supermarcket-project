@app.route('/autocomplete-search', methods=['GET'])
def autocomplete_search():
    query = request.args.get('query', '').strip()
    print(f"Search query received: '{query}'")  # Log the search query

    if not query:
        return jsonify({"message": "No query provided"}), 400

    # Check if the query matches the product names
    products = Product.query.filter(Product.name.ilike(f'%{query}%')).all()
    print(f"Products found: {len(products)}")  # Check how many products are found

    if not products:
        return jsonify({"message": "Aucun produit trouvé"}), 404

    # Prepare the product data to return in the response
    product_list = [{
        'id': product.id,
        'name': product.name,
        'sale_price': product.sale_price,
        'image_url': product.image_url
    } for product in products]

    print(f"Returning products: {product_list}")  # Log the product list being returned

    return jsonify(product_list)
