<link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link href="{{url('assets/cs/main.css?v=1.1')}}" rel="stylesheet" type="text/css" />
       <meta name="csrf-token" content="{{csrf_token()}}">

<section class="content-main">
    <div class="container-sm">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body p-4 text-center">
                <!-- Illustration -->
               
    <img src="{{ asset('assets/imgs/theme/2FA.png') }}" alt="2FA Security" style="width: 200px; margin-bottom: 15px;">
    
                  
                    <h3>Two-Factor Verification</h3>
                    <p class="text-muted">Enter your 6-digit authentication code</p>

                  

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('2fa.verify') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" 
                               name="code" 
                               class="form-control form-control-lg text-center"
                               placeholder="••••••"
                               maxlength="6"
                               pattern="\d{6}"
                               required
                               style="letter-spacing: 0.5em;
                                      font-size: 1.5rem;
                                      height: 50px">
                                      <br>

@error('code')
<div class="alert-icon-container">
    <i class="fas fa-exclamation-circle me-2 text-danger"></i>
    <span class="text-danger">{{ $message }}</span>
</div>@enderror
                    </div>


                    

{{-- Nouveau bloc --}}

                    <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle me-2"></i> Verify Code
                    </button>
                    <div class="mt-3">
                        <a href="" class="text-decoration-none">
                            Dont has access ? <strong> Use your secret key</strong>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.auth-icon {
        width: 70px;
        height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e3f2fd;
    }


    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-top: 2rem;
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.02);
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=text] {
        caret-color: transparent;
    }

    input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25,135,84,0.15);
    }

    .btn-primary {
        text-align: center;
        font-weight: bold;
        height: 50px;
        transition: background 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background: #157347;
    }
</style>
