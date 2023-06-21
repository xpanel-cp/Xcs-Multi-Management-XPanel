<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0"><?php echo confirm_dev_lang;?> <a href="https://github.com/Alirezad07/" target="_blank">Alirezad07</a></p
                >
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="/documents">API</a></li>
                    <li class="list-inline-item"><a href="https://github.com/Alirezad07/X-Panel-SSH-User-Management/blob/main/README-EN.md#supporting-us-hearts">Supporting us</a></li>
                    <li class="list-inline-item"><a href="https://github.com/Alirezad07/X-Panel-SSH-User-Management">GitHub</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- [Page Specific JS] start -->
<script src="<?php echo path ?>assets/js/plugins/apexcharts.min.js"></script>

<!-- [Page Specific JS] end -->
<!-- Required Js -->
<script src="<?php echo path ?>assets/js/plugins/popper.min.js"></script>
<script src="<?php echo path ?>assets/js/plugins/simplebar.min.js"></script>
<script src="<?php echo path ?>assets/js/plugins/bootstrap.min.js"></script>
<script src="<?php echo path ?>assets/js/fonts/custom-font.js"></script>
<script src="<?php echo path ?>assets/js/config.js?v=3.4"></script>
<script src="<?php echo path ?>assets/js/pcoded.js"></script>
<script src="<?php echo path ?>assets/js/plugins/feather.min.js"></script>
<!-- [Page Specific JS] start -->
<script src="<?php echo path ?>assets/js/plugins/simple-datatables-<?php echo LANG;?>.js"></script>
<script src="<?php echo path ?>assets/js/clipboard.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="<?php echo path ?>assets/js/persian-date.js"></script>
<script src="<?php echo path ?>assets/js/persian-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".example1").persianDatepicker({
            initialValue: false,
            observer: false,
            format: 'YYYY/MM/DD',
            altField: '.observer-example-alt',
            autoClose: true
        });
    });
</script>
<script>

    // basic example
    new ClipboardJS('[data-clipboard=true]').html()('success', function (e) {
        e.clearSelection();
        alert('Copied!');
    });
</script>
<script>
    const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: true,
        perPage: 25
    });
</script>

<!-- [Page Specific JS] end -->
</body>
<!-- [Body] end -->

</html>
