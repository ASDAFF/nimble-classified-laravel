<footer class="footer text-right">

    {{ $setting->copy_right_text }}

</footer>

</div>

<script>
    var resizefunc = [];

</script>
<!-- jQuery  -->
<script src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>
<script type="application/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
{{--<script type="application/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>--}}
<script type="application/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" ></script>
<script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/detect.js') }}"></script>
<script src="{{ asset('admin_assets/js/fastclick.js') }}">

</script><script src="{{ asset('admin_assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('admin_assets/js/waves.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.scrollTo.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('admin_assets/js/jquery.core.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.app.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}?v={{time()}}"></script>
<!-- Sweet-Alert  -->
<script src="{{ asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js') }}"></script>
<!-- dataTables JS  -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script type="application/javascript" src="{{ asset('admin_assets/plugins/jquery-tree/minified/jquery.tree.min.js') }}"></script>

<!--  color picker -->
<script src="{{ asset('admin_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
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
</body>
</html>