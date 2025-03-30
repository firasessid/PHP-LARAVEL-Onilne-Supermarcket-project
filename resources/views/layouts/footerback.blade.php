<footer class="main-footer font-xs">
                <div class="row pb-30 pt-15">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        &copy; Supernet .
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end">All rights reserved</div>
                    </div>
                </div>
            </footer>
        </main>

        <script src="{{url('assets/jsc/vendors/jquery-3.6.0.min.js')}}"></script>
        <script src="{{url('assets/jsc/vendors/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('assets/jsc/vendors/select2.min.js')}}"></script>
        <script src="{{url('assets/jsc/vendors/perfect-scrollbar.js')}}"></script>
        <script src="{{url('assets/jsc/vendors/jquery.fullscreen.min.js')}}"></script>
        <script src="{{url('assets/jsc/vendors/chart.js')}}"></script>
        <!-- Main Script -->
        <script src="{{url('assets/jsc/main.js?v=1.1')}}" type="text/javascript"></script>
        <script src="{{url('assets/jsc/custom-chart.js')}}" type="text/javascript"></script>
        <script src="{{url('assets/jsc/sweetalert2.min.js')}}" type="text/javascript"></script>
        <script src="{{url('assets/jsc/dropzone-min.min.js')}}" type="text/javascript"></script>
        <script src="{{url('assets/jsc/switchery.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
         $.ajaxSetup({
           headers : {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
         });
    </script>
    </body>




</html>
