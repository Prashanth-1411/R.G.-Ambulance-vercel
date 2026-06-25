        </div><!-- /page-content -->
    </div><!-- /main-wrapper -->
</div><!-- /app -->

<!-- Command palette -->
<div class="command-palette-overlay" id="commandPaletteOverlay"></div>
<div class="command-palette" id="commandPalette">
    <div class="command-search-wrapper">
        <i class="ti ti-search"></i>
        <input type="text" class="command-input" id="commandInput" placeholder="Type a command or search..." autofocus>
        <span class="text-muted small">ESC to close</span>
    </div>
    <div class="command-results" id="commandResults"></div>
</div>

<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= BASE_URL ?>/admin/assets/js/admin.js"></script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
