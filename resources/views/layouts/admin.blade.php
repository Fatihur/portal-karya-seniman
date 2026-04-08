@extends('adminlte::page')

{{-- Bootstrap Icons CSS --}}
@section('adminlte_css')
    @parent
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@stop

{{-- Flash Messages --}}
@section('content_header')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Akses Ditolak!</h5>
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
    @endif
@stop

{{-- Icon Picker Styles --}}
@push('css')
<style>
    .icon-picker-container {
        position: relative;
    }
    .icon-picker-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        margin-top: 5px;
    }
    .icon-picker-dropdown.show {
        display: block;
    }
    .icon-picker-search {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .icon-picker-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 8px;
    }
    .icon-picker-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.2rem;
        color: #6c757d;
    }
    .icon-picker-item:hover {
        border-color: #B83B3B;
        background: #f8f9fa;
        color: #B83B3B;
    }
    .icon-picker-item.selected {
        border-color: #B83B3B;
        background: #B83B3B;
        color: white;
    }
    .icon-preview-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .icon-preview-box {
        width: 38px;
        height: 38px;
        border: 2px dashed #ced4da;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #6c757d;
        background: #f8f9fa;
    }
    .icon-preview-box.has-icon {
        border-color: #B83B3B;
        background: white;
        color: #B83B3B;
    }
</style>
@endpush

{{-- Inject Logout Form and Script --}}
@section('adminlte_js')
    @parent
    
    {{-- Hidden Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    {{-- Logout Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle sidebar logout click
            var logoutLink = document.getElementById('logout-sidebar-link');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        });
    </script>
    
    {{-- Icon Picker Script --}}
    <script>
        // Bootstrap Icons Common Set
        const bootstrapIcons = [
            'bi-house', 'bi-building', 'bi-bank', 'bi-shop', 'bi-hospital',
            'bi-people', 'bi-person', 'bi-person-circle', 'bi-person-fill',
            'bi-palette', 'bi-brush', 'bi-paint-bucket', 'bi-easel',
            'bi-music-note', 'bi-music-note-beamed', 'bi-music-player',
            'bi-camera', 'bi-film', 'bi-film-strip', 'bi-image',
            'bi-book', 'bi-journal', 'bi-newspaper', 'bi-pencil',
            'bi-award', 'bi-trophy', 'bi-star', 'bi-stars',
            'bi-heart', 'bi-heart-fill', 'bi-love',
            'bi-globe', 'bi-geo-alt', 'bi-map', 'bi-pin-map',
            'bi-envelope', 'bi-telephone', 'bi-phone', 'bi-chat',
            'bi-calendar', 'bi-clock', 'bi-clock-history',
            'bi-folder', 'bi-folder-fill', 'bi-archive',
            'bi-tag', 'bi-tags', 'bi-bookmark', 'bi-bookmark-fill',
            'bi-search', 'bi-zoom-in', 'bi-zoom-out',
            'bi-eye', 'bi-eye-fill', 'bi-eye-slash',
            'bi-hand-thumbs-up', 'bi-hand-thumbs-down',
            'bi-share', 'bi-send', 'bi-mailbox',
            'bi-box', 'bi-box-seam', 'bi-gift', 'bi-bag',
            'bi-cart', 'bi-cart-fill', 'bi-cart-check',
            'bi-cash', 'bi-credit-card', 'bi-wallet',
            'bi-gear', 'bi-gear-fill', 'bi-tools', 'bi-wrench',
            'bi-sliders', 'bi-sliders2', 'bi-funnel',
            'bi-brightness-high', 'bi-moon', 'bi-sun',
            'bi-cloud', 'bi-cloud-sun', 'bi-cloud-rain',
            'bi-bicycle', 'bi-car-front', 'bi-bus-front',
            'bi-airplane', 'bi-train-front', 'bi-rocket',
            'bi-flower1', 'bi-flower2', 'bi-flower3', 'bi-tree',
            'bi-cup', 'bi-cup-fill', 'bi-cup-straw',
            'bi-egg', 'bi-egg-fried', 'bi-basket',
            'bi-balloon', 'bi-balloon-fill', 'bi-balloon-heart',
            'bi-emoji-smile', 'bi-emoji-laughing', 'bi-emoji-sunglasses',
            'bi-lightning', 'bi-lightning-charge', 'bi-battery-full',
            'bi-wifi', 'bi-bluetooth', 'bi-broadcast',
            'bi-shield', 'bi-shield-check', 'bi-shield-lock',
            'bi-key', 'bi-lock', 'bi-unlock',
            'bi-flag', 'bi-flag-fill', 'bi-pin', 'bi-pin-angle',
            'bi-link', 'bi-link-45deg', 'bi-paperclip',
            'bi-printer', 'bi-laptop', 'bi-pc-display',
            'bi-phone', 'bi-tablet', 'bi-watch',
            'bi-cpu', 'bi-memory', 'bi-hdd', 'bi-hdd-network',
            'bi-router', 'bi-server', 'bi-database',
            'bi-file', 'bi-file-earmark', 'bi-files',
            'bi-file-image', 'bi-file-music', 'bi-file-play',
            'bi-calendar-event', 'bi-calendar-check', 'bi-calendar-date',
            'bi-clock', 'bi-stopwatch', 'bi-hourglass',
            'bi-bell', 'bi-bell-fill', 'bi-alarm',
            'bi-megaphone', 'bi-mic', 'bi-mic-fill',
            'bi-headphones', 'bi-speaker', 'bi-volume-up',
            'bi-camera-video', 'bi-camera-video-fill', 'bi-webcam',
            'bi-binoculars', 'bi-compass', 'bi-geo',
            'bi-activity', 'bi-graph-up', 'bi-graph-down',
            'bi-bar-chart', 'bi-bar-chart-line', 'bi-pie-chart',
            'bi-speedometer', 'bi-speedometer2',
            'bi-reception-0', 'bi-reception-1', 'bi-reception-2', 'bi-reception-3', 'bi-reception-4',
            'bi-briefcase', 'bi-briefcase-fill', 'bi-bag-check',
            'bi-backpack', 'bi-backpack-fill', 'bi-bag-dash',
            'bi-mask', 'bi-mask-theater', 'bi-film',
            'bi-projector', 'bi-dice-1', 'bi-dice-2', 'bi-dice-3', 'bi-dice-4', 'bi-dice-5', 'bi-dice-6',
            'bi-controller', 'bi-joystick', 'bi-usb-drive',
            'bi-boombox', 'bi-speaker', 'bi-speaker-fill',
            'bi-stripe', 'bi-paypal', 'bi-credit-card-2-front',
            'bi-patch-check', 'bi-patch-check-fill', 'bi-patch-exclamation',
            'bi-circle', 'bi-circle-fill', 'bi-record-circle',
            'bi-square', 'bi-square-fill', 'bi-check-square',
            'bi-triangle', 'bi-triangle-fill', 'bi-pentagon',
            'bi-hexagon', 'bi-octagon', 'bi-heart',
            'bi-diamond', 'bi-gem', 'bi-egg',
            'bi-capsule', 'bi-capsule-pill', 'bi-bandaid',
            'bi-prescription', 'bi-prescription2', 'bi-clipboard',
            'bi-clipboard-check', 'bi-clipboard-data', 'bi-clipboard-plus',
            'bi-journal-text', 'bi-journal-check', 'bi-journal-medical',
            'bi-file-medical', 'bi-file-medical-alt',
            'bi-heart-pulse', 'bi-lungs', 'bi-brain',
            'bi-virus', 'bi-bacteria', 'bi-bandaid-fill',
            'bi-scissors', 'bi-eyedropper', 'bi-thermometer',
            'bi-stethoscope', 'bi-hammer', 'bi-bricks',
            'bi-cone', 'bi-cone-striped', 'bi-sign-stop',
            'bi-sign-stop-lights', 'bi-sign-turn-left', 'bi-sign-turn-right',
            'bi-traffic-light', 'bi-ev-station', 'bi-fuel-pump',
            'bi-bucket', 'bi-mop', 'bi-brush',
            'bi-droplet', 'bi-droplet-fill', 'bi-water',
            'bi-snow', 'bi-snow2', 'bi-snow3',
            'bi-fire', 'bi-fireplace', 'bi-candle',
            'bi-incognito', 'bi-glasses', 'bi-sunglasses',
            'bi-umbrella', 'bi-umbrella-fill', 'bi-rainbow',
            'bi-brightness-alt-high', 'bi-brightness-alt-low',
            'bi-grid', 'bi-grid-fill', 'bi-grid-3x3',
            'bi-border-all', 'bi-border-style', 'bi-border-outer',
            'bi-window', 'bi-window-fullscreen', 'bi-window-stack',
            'bi-menu-up', 'bi-menu-down', 'bi-menu-button',
            'bi-chevron-up', 'bi-chevron-down', 'bi-chevron-left', 'bi-chevron-right',
            'bi-arrow-up', 'bi-arrow-down', 'bi-arrow-left', 'bi-arrow-right',
            'bi-caret-up', 'bi-caret-down', 'bi-caret-left', 'bi-caret-right',
            'bi-upload', 'bi-download', 'bi-cloud-upload', 'bi-cloud-download',
            'bi-box-arrow-in-up', 'bi-box-arrow-in-down', 'bi-box-arrow-in-left', 'bi-box-arrow-in-right',
            'bi-box-arrow-up', 'bi-box-arrow-down', 'bi-box-arrow-left', 'bi-box-arrow-right',
            'bi-trash', 'bi-trash-fill', 'bi-x-lg', 'bi-x-circle',
            'bi-check-lg', 'bi-check-circle', 'bi-check-all',
            'bi-plus-lg', 'bi-plus-circle', 'bi-plus-square',
            'bi-dash-lg', 'bi-dash-circle', 'bi-dash-square',
            'bi-info-lg', 'bi-info-circle', 'bi-exclamation-lg', 'bi-exclamation-circle',
            'bi-question-lg', 'bi-question-circle', 'bi-question-diamond',
            'bi-slash-lg', 'bi-asterisk', 'bi-hash',
            'bi-at', 'bi-link-45deg', 'bi-envelope-at',
            'bi-envelope-open', 'bi-envelope-fill', 'bi-envelope-heart',
            'bi-chat-left', 'bi-chat-right', 'bi-chat-dots',
            'bi-telegram', 'bi-whatsapp', 'bi-instagram',
            'bi-facebook', 'bi-twitter', 'bi-youtube',
            'bi-tiktok', 'bi-linkedin', 'bi-github',
            'bi-google', 'bi-microsoft', 'bi-apple',
            'bi-browser-chrome', 'bi-browser-firefox', 'bi-browser-edge',
            'bi-bootstrap', 'bi-bootstrap-fill', 'bi-bootstrap-reboot'
        ];

        function initIconPicker(inputId, previewId, dropdownId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const dropdown = document.getElementById(dropdownId);
            
            if (!input || !preview || !dropdown) return;
            
            // Build icon grid
            function buildIconGrid(filter = '') {
                const icons = filter 
                    ? bootstrapIcons.filter(icon => icon.includes(filter.toLowerCase()))
                    : bootstrapIcons;
                    
                let html = '<div class="icon-picker-grid">';
                icons.forEach(icon => {
                    const isSelected = input.value === icon ? 'selected' : '';
                    html += `<div class="icon-picker-item ${isSelected}" data-icon="${icon}" title="${icon}">
                        <i class="bi ${icon}"></i>
                    </div>`;
                });
                html += '</div>';
                return html;
            }
            
            // Update preview
            function updatePreview() {
                if (input.value) {
                    preview.innerHTML = `<i class="bi ${input.value}"></i>`;
                    preview.classList.add('has-icon');
                } else {
                    preview.innerHTML = '<i class="bi bi-image"></i>';
                    preview.classList.remove('has-icon');
                }
            }
            
            // Create picker HTML
            dropdown.innerHTML = `
                <input type="text" class="icon-picker-search" placeholder="Cari icon... (contoh: house, music, user)">
                <div class="icon-picker-content">${buildIconGrid()}</div>
            `;
            
            // Toggle dropdown
            preview.addEventListener('click', function() {
                dropdown.classList.toggle('show');
                if (dropdown.classList.contains('show')) {
                    dropdown.querySelector('.icon-picker-search').focus();
                }
            });
            
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!preview.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
            
            // Search functionality
            const searchInput = dropdown.querySelector('.icon-picker-search');
            searchInput.addEventListener('input', function() {
                dropdown.querySelector('.icon-picker-content').innerHTML = buildIconGrid(this.value);
                attachIconClickHandlers();
            });
            
            // Icon selection
            function attachIconClickHandlers() {
                dropdown.querySelectorAll('.icon-picker-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const iconClass = this.dataset.icon;
                        input.value = iconClass;
                        updatePreview();
                        dropdown.classList.remove('show');
                        
                        // Update selected state
                        dropdown.querySelectorAll('.icon-picker-item').forEach(i => i.classList.remove('selected'));
                        this.classList.add('selected');
                    });
                });
            }
            
            attachIconClickHandlers();
            updatePreview();
        }
        
        // Auto-init on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('ikon')) {
                initIconPicker('ikon', 'icon-preview', 'icon-picker-dropdown');
            }
        });
    </script>
@stop
