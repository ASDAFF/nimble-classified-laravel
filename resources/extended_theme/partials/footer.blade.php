<?php
$cat = DB::table('categories')->where('status', 1)->groupBy('name')->get()->toArray();
?>
<!-- footer -->
<footer id="footer" class="clearfix">
    <!-- footer-top -->
    <section class="footer-top clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-md-8 col-sm-8 col-xs-6">
                    <div class=" col-lg-3 col-md-23 col-sm-3 col-xs-6 ">
                        <a href="{{route('contact-us')}}">Contact Us</a>
                    </div>
                    <?php
                    $pages = \App\CustomPage::select('title','slug')->orderBy('sort', 'asc')->get();
                    ?>
                    @foreach($pages as $item)
                        <div class=" col-lg-3 col-md-23 col-sm-3 col-xs-6 ">
                            <a href="{{ url('page/'.$item->slug) }}">{{ ucfirst($item->title) }}</a>
                        </div>
                    @endforeach
                </div>
                @if($setting->social_links == 1)
                    <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <div class="footer-col footer-widget social-widget">
                            <h4 class="footer-title">Follow Us</h4>
                            <ul>
                                @if($setting->facebook !='')
                                    <li ><a href="{{ $setting->facebook }}" target="_blank"><i class="fa fa-facebook-official"></i></a></li>

                                @endif
                                @if($setting->twitter !='')
                                    <li><a href="{{ $setting->twitter }}" target="_blank"> <i class="fa fa-twitter-square"></i> </a></li>
                                @endif
                                @if($setting->googleplus !='')
                                    <li><a href="{{ $setting->googleplus }}"><i class="fa fa-google-plus-official"></i> @else</a></li>
                                @endif
                                @if($setting->linkedin !='')
                                    <li><a href="{{ $setting->linkedin }}"><i class="fa fa-linkedin-square"></i></a><li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
                <div style="clear: both"></div>
                <div class="col-lg-12">
                    <div class="m-t-20" style="background-image: url('{{asset('assets/img/footer_bg.png')}}'); height: 2px"></div>
                    <div class=" text-center paymanet-method-logo">
                        <div class="copy-info text-center">
                            {{ (isset($setting->copy_right_text))? $setting->copy_right_text : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container -->
    </section><!-- footer-top -->

</footer><!-- footer -->


@if(!Auth::guest() && Auth::user()->type == 'adm')
<!--/Preset Style Chooser-->
<div class="style-chooser">
    <div class="style-chooser-inner">
        <a href="#" class="toggler"><i class="fa fa-life-ring fa-spin"></i></a>
        <h4>Presets</h4>
        <ul class="preset-list clearfix">
            <li class="preset1 active" data-preset="1"><a href="#" data-color="preset1"></a></li>
            <li class="preset2" data-preset="2"><a href="#" data-color="preset2"></a></li>
            <li class="preset3" data-preset="3"><a href="#" data-color="preset3"></a></li>
            <li class="preset4" data-preset="4"><a href="#" data-color="preset4"></a></li>
        </ul>
    </div>
</div>
<!--End:Preset Style Chooser-->
@endif
<!-- LOADING  -->
<div style=" top: 0px; bottom: 0px; left: 0px; position: fixed; width: 100%; z-index: 999999; display: none; background: rgba(0,0,0,0.5);" id="loading">
    <div style="margin: 20% 45%; text-align: center;">
        <img src="{!! asset('assets/images/loader1.gif') !!}" alt=""  class="loading"><br />
        <span style="color: mintcream;"> Processing...</span>
    </div>
</div>
<!-- JS -->
<script src="{{ asset('assets/js/extended_js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/smoothscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/scrollup.min.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/price-range.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/jquery.countdown.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/custom.js') }}"></script>
<script src="{{ asset('assets/js/extended_js/switcher.js') }}"></script>

<!-- Sweet-Alert  -->
<script src="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js') }}"></script>

<!-- dataTables JS  -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>

<!-- Toastr js -->
<script src="{{ asset('admin_assets/plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('assets/js/common.js') }}"></script>

@if( !Auth::guest())
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        // check login status
        setInterval(function() {

            $.get('{{ url('login_status') }}', function(data){

            });
            //
        }, 99000);
    </script>
    @if($setting->live_chat!=0)
        @include('chat.test')
    @endif
@endif

@if($setting->translate == 1)
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                //includedLanguages: 'et',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

@endif
{!! @$setting->footer_script !!}
</body>
</html>