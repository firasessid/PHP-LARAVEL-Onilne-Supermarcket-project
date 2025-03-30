@section('content')
@extends('layouts.back-main')

@section('main-container')



<style>
    .input-container {
        position: relative;
    }

    .is-invalid {
        border: 1px solid red;
        /* Red border */
    }

    .fa-exclamation-circle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: red;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }

    input.error,
    select.error {
        border: 1px solid red;
    }

</style>

<section class="content-main">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="row">

        @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error'
                , title: 'Oops...'
                , text: 'Something went wrong...'
                , onBeforeOpen: () => {
                    const dialog = Swal.getPopup();
                    dialog.style.border = '2px solid red';
                    dialog.style.padding = '10px';
                }
                , footer: '<a href="#">Why do I have this issue?</a>'

            });

        </script>
        @endif

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-9">
                <div class="content-header">
                    <h2 class="content-title">Add New User</h2>
                    <div>
                        <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                        <button id="showAlertButton" type="submit" class="btn btn-md rounded font-sm hover-up ">Publich</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic</h4>

                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-4">
                                <label for="name" class="form-label">User name</label>
                                <div class="input-container">
                                    <input type="text" id="name" name="name" placeholder="User Name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <i class="fas fa-exclamation-circle"></i>
                                    <div class="error-message">{{ $message }}</div>

                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4">
                                    <label for="slug" class="form-label">Email</label>
                                    <div class="row gx-2">
                                        <div class="input-container">
                                            <input  type="text" id="email" name="email" placeholder="email" class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                            <i class="fas fa-exclamation-circle"></i>
                                            <div class="error-message">{{ $message }}</div>

                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="form-label">Password</label>
                                    <div class="row gx-2">
                                        <div class="input-container">
                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                            <i class="fas fa-exclamation-circle"></i>
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="form-label">Confirm Password</label>
                                    <div class="row gx-2">
                                        <div class="input-container">
                                            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" class="form-control @error('confirm-password') is-invalid @enderror">
                                            @error('confirm_password')
                                            <i class="fas fa-exclamation-circle"></i>
                                            <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                   <div class="mb-4">
                                    <div class="row gx-2">
                                        <div class="input-container">


                                            <label for="role" class="form-label">Role</label>

                                            <select class="form-select" id="role" name="roles">
                                                @foreach ($roles as $r)
                                                @unless ($r=== 'admin')

                                                <option value="{{ $r }}">{{ $r }}</option>
                                                @endunless

                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>





                        </form>
                    </div>

                </div>
                <!-- card end// -->

                <!-- card end// -->

            </div>

        </form>

    </div>
</section>
@endsection
@endsection
@section('customJs')

<script>
    document.getElementById("showAlertButton").addEventListener("click", function() {
        let timerInterval
        Swal.fire({
            title: '<span style="color: green;">Waiting...!</span>'
            , html: 'Creating new user.'
            , timer: 4000
            , timerProgressBar: true
            , didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            }
            , willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })

    });










</script>
@endsection

