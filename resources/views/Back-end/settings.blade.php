

@section('content')
@extends('layouts.back-main')
@section('main-container')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Profile setting</h2>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
    @if(session('success_2fa'))
                                <div class="alert-success animate-bounce-in mb-6">
                                    <i class="fas fa-check-circle mr-2"></i>{{ session('success_2fa') }}
                                </div>
                                @endif

                                @if(session('error_2fa'))
                                <div class="alert-danger animate-shake mb-6">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error_2fa') }}
                                </div>
                                @endif
    <div class="card">
        <div class="card-body">
            <div class="row gx-5">

                <aside class="col-lg-3 border-end">
                    <nav class="nav nav-pills flex-lg-column mb-4" id="profileTabs" role="tablist">
                        <a class="nav-link" id="general-tab" data-bs-toggle="tab" href="#general" role="tab"
                            aria-controls="general" aria-selected="true">General</a>
                        <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                            aria-controls="password" aria-selected="false">Password</a>
                            @unless (Auth::user()->hasRole('client'))

                            <a class="nav-link" id="tab-2fa" data-bs-toggle="tab" href="#tab-2fa-content" role="tab"
                            aria-controls="tab-2fa-content" aria-selected="false">Two-Factor Authentication</a>
                        <a class="nav-link" id="session-tab" data-bs-toggle="tab" href="#session" role="tab"
                            aria-controls="session" aria-selected="false">Logs access</a>
                            @endunless
                                                </nav>
                </aside>

                <div class="col-lg-9">
                    <section class="content-body p-xl-4">
                        <div class="tab-content" id="profileTabsContent">



                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                aria-labelledby="general-tab">
                               
                               @if(session('success_profile'))
                                <div class="alert alert-success mb-4" style="background-color: #d8f1e5; border-color: #c3e6cb;">
                                    {{ session('success_profile') }}
                                </div>
                                @endif
                                <form method="POST" action="{{ route('update.profile') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row gx-3">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input class="form-control" name="name" type="text"
                                                        placeholder="Type here" value="{{ Auth::user()->name }}" />
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                        placeholder="example@mail.com"
                                                        value="{{ Auth::user()->email }}" />
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input class="form-control" type="tel" name="phone"
                                                        placeholder="+1234567890" value="{{ Auth::user()->phone }}" />
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input class="form-control" type="text" name="address"
                                                        placeholder="Type here" value="{{ Auth::user()->address }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <aside class="col-lg-4">
                                            <figure class="text-lg-center">
                                                <img class="img-lg mb-3 img-avatar"
                                                    src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                                    alt="User Photo" />
                                                <figcaption>
                                                    <label class="btn btn-light rounded font-md">
                                                        Upload
                                                        <input type="file" name="avatar" style="display: none;">
                                                    </label>
                                                </figcaption>
                                            </figure>
                                        </aside>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                            </div>


                            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                @if(session('success_password'))
                                <div class="alert alert-success mb-4" style="background-color: #d8f1e5; border-color: #c3e6cb;">
                                    {{ session('success_password') }}
                                </div>
                                @endif
                                
                            

                                <form method="POST" action="{{ route('update.password') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input placeholder="current password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                            <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input placeholder="new password" type="password" class="form-control"
                                            id="new_password" name="new_password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New
                                            Password</label>
                                        <input placeholder="confirm password" type="password" class="form-control"
                                            id="new_password_confirmation" name="new_password_confirmation">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                            </div>


                            <div class="tab-pane fade" id="tab-2fa-content" role="tabpanel" aria-labelledby="tab-2fa">
                          
@php
    // Refresh user data
    $user = Auth::user()->fresh();
@endphp

<div class="space-y-6">
    @if($user->google2fa_secret && !session('2fa_verified'))
    <div class="qr-section">
   
    <div class="text-center">
   
    <h4>Scan QR Code with Google Authenticator</h4>
        <div class="qr-container my-3">
            {!! $qrCode !!}
        </div>
        <div class="secret-key-group mt-4">
            <div class="input-group relative" style="max-width: 400px; margin: 0 auto;">
                <input type="text" 
                       value="{{ $secretKey }}" 
                       id="secretKey"
                       class="form-control"
                       readonly>
                <button onclick="copySecret()" 
                        class="btn btn-secondary">
                    Copy
                </button>
            </div>
            <small class="text-muted mt-2 d-block">
                🔑 Save this key securely
            </small>
        </div>
    </div>

    <form action="{{ route('2fa.enable') }}" method="POST" class="mt-4" style="max-width: 400px; margin: 0 auto;">
        @csrf
        <div class="mb-3">
            <label class="form-label">Verification Code</label>
            <input type="text" 
                   name="code" 
                   class="form-control"
                   placeholder="Enter 6-digit code"
                   required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                       Enable 2FA
                    </button>
    </form>
</div>

    @elseif($user->google2fa_secret && session('2fa_verified'))
        <!-- Disable 2FA Section -->
        <div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            
            <h3>Disable Two-Factor Authentication</h3>
            <p class="text-muted">2FA is currently active. To disable it, confirm your password below.</p>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('2fa.disable') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="form-control form-control-lg"
                       placeholder="Enter your password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                       Disable 2FA
                    </button>
        </form>
    </div>
</div>

<style>
    .auth-icon {
        width: 70px;
        height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
    }

    input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
    }
</style>

    @else
    <div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/imgs/theme/2FA.png') }}" alt="2FA Security" style="width: 130px; margin-bottom: 15px;">
            <h3>Protect Your Account</h3>
            <p class="text-muted">
                Add an extra layer of security to your account by enabling two-factor authentication.
            </p>
        </div>

        <form action="{{ route('2fa.generate.secret') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
Generate new secret key                     </button>
        </form>
    </div>
</div>

<style>
    .auth-icon {
        width: 70px;
        height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
    }

    button:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.25);
    }
</style>

    @endif
    </div>              
    </div>              

    <div class="tab-pane fade" id="session" role="tabpanel" aria-labelledby="session-tab">
    <style>
        :root {
            --primary-color: #6366f1;
            --success-bg: #f0fdf4;
            --success-text: #16a34a;
            --surface-color: #ffffff;
            --text-secondary: #64748b;
        }
        .device-icon {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        color: #0f172a; /* Couleur du texte */
    }

    .device-icon svg {
        width: 24px;
        height: 24px;
        stroke: #3bb77e; /* Couleur de l'icône */
        stroke-width: 1.5;
        transition: stroke 0.2s ease;
    }

    .device-icon:hover svg {
        stroke: #2f935f; /* Couleur au hover */
    }
        .session-card {
            width: 100%;
            max-width: 680px;
            background: var(--surface-color);
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 24px;
            transition: transform 0.2s ease;
        }

        .session-card:hover {
            transform: translateY(-2px);
        }

        .session-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            background: linear-gradient(45deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #f1f5f9;
        }

        .session-card-header .device-icon {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            color: #0f172a;
        }

        .session-card-header .device-icon svg {
            width: 24px;
            height: 24px;
            color: var(--primary-color);
        }

        .session-card-header .session-status {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-card-content {
            padding: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .session-detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .session-detail-item label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 400;
        }

        .session-detail-item .value {
            font-weight: 500;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-alert {
            grid-column: 1 / -1;
            background: var(--success-bg);
            color: var(--success-text);
            padding: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
            border: 1px solid #dcfce7;
        }

        .session-alert svg {
            flex-shrink: 0;
            color: #22c55e;
            width: 24px;
            height: 24px;
        }

        .action-button {
        background: #3bb77e;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .action-button:hover {
        background: #2f935f; /* Version 20% plus sombre */
        transform: translateY(-1px);
    }

    .action-button:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
    }

    .action-button svg {
        stroke: white; /* Couleur de l'icône */
    }

        @media (max-width: 640px) {
            .session-card-content {
                grid-template-columns: 1fr;
            }
            
            .session-card-header {
                padding: 16px;
            }
        }
    </style>

    @if ($latestSession)
        <div class="session-card">
            <div class="session-card-header">
                
<div class="device-icon">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
    </svg>
    {{ $latestSession->device_type }}
</div>
                
                  
                    <button class="action-button" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        End Session
                    </button>
            </div>

            <div class="session-card-content">
                <div class="session-detail-item">
                    <label>Location</label>
                    <div class="alert-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        {{ $latestSession->location }}
                    </div>
                </div>

                <div class="session-detail-item">
                    <label>Browser</label>
                    <div class="alert-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"></path>
                        </svg>
                        {{ $latestSession->browser }}
                    </div>
                </div>

                <div class="session-detail-item">
                    <label>IP Address</label>
                    <div class="alert-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                        {{ $latestSession->ip_address }}
                    </div>
                </div>

                <div class="session-detail-item">
                    <label>Last Activity</label>
                    <div class="alert-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        {{ \Carbon\Carbon::parse($latestSession->login_time)->diffForHumans() }}
                    </div>
                </div>

                <div class="session-alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M12 8v4M12 16h.01"></path>
                    </svg>
                    <div>
                        <h4 class="alert-title">Session Secure</h4>
                        <p class="alert-description">No suspicious activity detected</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <!-- Ajouter ici un état vide stylisé si nécessaire -->
        </div>
    @endif
</div>                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection