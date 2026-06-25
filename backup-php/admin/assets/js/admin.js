/**
 * Admin Panel — Main JavaScript
 * Premium UI interactions, DataTables, notifications, search, theme
 */
(function() {
    'use strict';

    // ===== CSRF =====
    const CSRF_TOKEN = document.querySelector('input[name="csrf_token"]')?.value || '';

    // ===== THEME =====
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('admin_theme') || 'dark';
    html.setAttribute('data-theme', savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('admin_theme', next);
        });
    }

    // ===== SIDEBAR TOGGLE =====
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        // Close sidebar on outside click (mobile)
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 &&
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // ===== TOAST NOTIFICATIONS =====
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        const icons = { success: 'ti-check', error: 'ti-x', warning: 'ti-alert-triangle', info: 'ti-info-circle' };
        const colors = { success: '#34d399', error: '#ef4444', warning: '#fbbf24', info: '#60a5fa' };
        const toast = document.createElement('div');
        toast.className = 'toast show';
        toast.style.cssText = `
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-left: 3px solid ${colors[type] || colors.success};
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 8px;
            box-shadow: var(--shadow-elevated);
            min-width: 280px;
            animation: slideInRight 0.3s ease;
        `;
        toast.innerHTML = `<div class="d-flex align-items-center gap-2">
            <i class="ti ${icons[type] || icons.success}" style="color: ${colors[type] || colors.success}; font-size: 1.2rem;"></i>
            <span class="small fw-semibold">${message}</span>
        </div>`;
        container.appendChild(toast);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 4000);
    };

    // ===== CONFIRM DELETE =====
    window.confirmDelete = function(url, message = 'Delete this item?') {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            background: 'var(--bg-card)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ csrf_token: CSRF_TOKEN, action: 'delete' })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.success) { showToast('Deleted successfully'); location.reload(); }
                    else showToast(d.message || 'Error', 'error');
                });
            }
        });
    };

    // ===== TOGGLE STATUS =====
    window.toggleStatus = function(url, element) {
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ csrf_token: CSRF_TOKEN, action: 'toggle_status' })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                const badge = element.querySelector('.status-badge') || element;
                if (d.status) {
                    badge.className = 'badge bg-success bg-opacity-10 text-success status-badge';
                    badge.textContent = 'Active';
                } else {
                    badge.className = 'badge bg-secondary bg-opacity-10 text-secondary status-badge';
                    badge.textContent = 'Inactive';
                }
                showToast('Status updated');
            } else showToast(d.message || 'Error', 'error');
        });
    };

    // ===== COMMAND PALETTE =====
    const cmdOverlay = document.getElementById('commandPaletteOverlay');
    const cmdPalette = document.getElementById('commandPalette');
    const cmdInput = document.getElementById('commandInput');
    const cmdResults = document.getElementById('commandResults');

    const COMMANDS = [
        { label: 'Dashboard', icon: 'ti-dashboard', url: '/admin/dashboard.php' },
        { label: 'Services', icon: 'ti-truck', url: '/admin/pages/services.php' },
        { label: 'Testimonials', icon: 'ti-message-star', url: '/admin/pages/testimonials.php' },
        { label: 'Blog Posts', icon: 'ti-news', url: '/admin/pages/blog.php' },
        { label: 'Gallery', icon: 'ti-photo', url: '/admin/pages/gallery.php' },
        { label: 'Bookings', icon: 'ti-calendar-stats', url: '/admin/pages/bookings.php' },
        { label: 'Inquiries', icon: 'ti-mail', url: '/admin/pages/inquiries.php' },
        { label: 'Team', icon: 'ti-users', url: '/admin/pages/team.php' },
        { label: 'Settings', icon: 'ti-settings', url: '/admin/pages/settings.php' },
        { label: 'Hero Slides', icon: 'ti-slideshow', url: '/admin/pages/hero-slides.php' },
        { label: 'Statistics', icon: 'ti-numbers', url: '/admin/pages/statistics.php' },
        { label: 'SEO Meta', icon: 'ti-search', url: '/admin/pages/seo.php' },
        { label: 'Navigation', icon: 'ti-menu-2', url: '/admin/pages/navigation.php' },
        { label: 'Certificates', icon: 'ti-certificate', url: '/admin/pages/certificates.php' },
        { label: 'Timeline', icon: 'ti-timeline', url: '/admin/pages/timeline.php' },
        { label: 'Activity Logs', icon: 'ti-activity', url: '/admin/pages/logs.php' },
        { label: 'Profile', icon: 'ti-user', url: '/admin/pages/profile.php' },
        { label: 'Logout', icon: 'ti-logout', url: '/admin/logout.php' },
    ];

    function openCommandPalette() {
        cmdPalette.classList.add('show');
        cmdOverlay.classList.add('show');
        setTimeout(() => cmdInput?.focus(), 100);
        renderCommands(COMMANDS);
    }

    function closeCommandPalette() {
        cmdPalette.classList.remove('show');
        cmdOverlay.classList.remove('show');
        if (cmdInput) cmdInput.value = '';
    }

    function renderCommands(items) {
        if (!cmdResults) return;
        cmdResults.innerHTML = items.map(item => `
            <a href="${item.url}" class="command-item">
                <i class="ti ${item.icon}"></i>
                <span>${item.label}</span>
            </a>
        `).join('');
    }

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openCommandPalette();
        }
        if (e.key === 'Escape') closeCommandPalette();
    });

    if (cmdOverlay) cmdOverlay.addEventListener('click', closeCommandPalette);
    if (cmdInput) {
        cmdInput.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            const filtered = COMMANDS.filter(c => c.label.toLowerCase().includes(q));
            renderCommands(filtered);
        });
    }

    // ===== GLOBAL SEARCH =====
    const globalSearch = document.getElementById('globalSearch');
    if (globalSearch) {
        globalSearch.addEventListener('focus', function() {
            openCommandPalette();
        });
    }

    // ===== NOTIFICATIONS =====
    function loadNotifications() {
        const list = document.getElementById('notificationList');
        const dot = document.getElementById('notificationDot');
        if (!list) return;

        fetch('/admin/ajax/crud.php?action=list&table=notifications&where=is_read=0&order=created_at+DESC&per_page=10')
            .then(r => r.json())
            .then(d => {
                if (d.success && d.data) {
                    if (d.data.length > 0) {
                        if (dot) dot.style.display = 'block';
                        list.innerHTML = d.data.map(n => `
                            <div class="px-3 py-2 border-bottom border-secondary notification-item" data-id="${n.id}">
                                <p class="mb-0 small fw-semibold">${n.title}</p>
                                <p class="mb-0 text-muted fs-11">${n.message || ''}</p>
                            </div>
                        `).join('');
                    } else {
                        list.innerHTML = '<div class="text-center text-muted py-4 small">No new notifications</div>';
                        if (dot) dot.style.display = 'none';
                    }
                }
            });
    }

    const notifBtn = document.getElementById('notificationBtn');
    const notifDropdown = document.getElementById('notificationDropdown');
    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isShow = notifDropdown.classList.contains('show');
            notifDropdown.classList.toggle('show');
            if (!isShow) loadNotifications();
        });
        document.addEventListener('click', function(e) {
            if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });
    }

    // Mark all read
    const markAllRead = document.getElementById('markAllRead');
    if (markAllRead) {
        markAllRead.addEventListener('click', function() {
            fetch('/admin/ajax/crud.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'mark_all_read', table: 'notifications', csrf_token: CSRF_TOKEN })
            }).then(() => { loadNotifications(); showToast('All notifications marked read'); });
        });
    }

    // ===== DATA TABLES INIT =====
    $(document).ready(function() {
        if ($.fn.dataTable) {
            $('.data-table').each(function() {
                const dt = $(this).DataTable({
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                    order: [[0, 'desc']],
                    language: {
                        search: '',
                        searchPlaceholder: 'Search...',
                        lengthMenu: '_MENU_ per page',
                        info: 'Showing _START_ to _END_ of _TOTAL_',
                        infoEmpty: 'No entries',
                        infoFiltered: '(filtered from _MAX_ total)'
                    },
                    dom: '<"d-flex align-items-center justify-content-between gap-3 mb-3"<"d-flex gap-2"l><"d-flex"f>>rt<"d-flex align-items-center justify-content-between mt-3"<"text-muted small"i><"pagination-wrap"p>>'
                });
                // Attach for reload
                $(this).data('dataTable', dt);
            });
        }
    });

    // ===== POLL NOTIFICATIONS =====
    setInterval(loadNotifications, 30000);

    // ===== PREVENT FORM DOUBLE SUBMIT =====
    document.addEventListener('submit', function(e) {
        const btn = e.target.querySelector('button[type="submit"]');
        if (btn && btn.disabled) { e.preventDefault(); return; }
        if (btn) { btn.disabled = true; setTimeout(() => { btn.disabled = false; }, 3000); }
    });

    // ===== IMAGE PREVIEW ON FILE INPUT =====
    document.addEventListener('change', function(e) {
        if (e.target.type === 'file' && e.target.dataset.preview) {
            const preview = document.querySelector(e.target.dataset.preview);
            if (preview && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) { preview.src = ev.target.result; };
                reader.readAsDataURL(e.target.files[0]);
            }
        }
    });

    console.log('%c RG Ambulance CMS v1.0 ', 'background:#3b82f6;color:#fff;font-weight:bold;padding:4px 8px;border-radius:4px;');
})();
