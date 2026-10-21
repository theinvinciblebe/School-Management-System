@extends('layout.main')

@section('content')
<style>
    /* Premium Styling Tokens & Utilities */
    :root {
        --theme-primary: #4f46e5;
        --theme-primary-hover: #4338ca;
        --theme-surface: #ffffff;
        --theme-border: #e2e8f0;
        --theme-text-main: #1e293b;
        --theme-text-muted: #64748b;
        --theme-radius-lg: 16px;
        --theme-radius-md: 12px;
        --theme-radius-sm: 8px;
        --theme-shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
        --theme-shadow-md: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
        --theme-shadow-lg: 0 20px 30px -8px rgba(15, 23, 42, 0.12);
    }

    .custom-studio {
        padding: 1.5rem 1rem 3rem 1rem;
        color: var(--theme-text-main);
        font-family: inherit;
    }

    /* Hero Header */
    .studio-header {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
        border-radius: var(--theme-radius-lg);
        padding: 2.25rem 2rem;
        margin-bottom: 2rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: var(--theme-shadow-lg);
    }

    .studio-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(129, 140, 248, 0.35) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .studio-header::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 20%;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(192, 132, 252, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .studio-header-content {
        position: relative;
        z-index: 2;
    }

    .studio-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .studio-badge .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #34d399;
        box-shadow: 0 0 10px #34d399;
        animation: pulseDot 2s infinite ease-in-out;
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.85); }
    }

    /* Studio Card Panels */
    .studio-card {
        background: var(--theme-surface);
        border: 1px solid var(--theme-border);
        border-radius: var(--theme-radius-lg);
        box-shadow: var(--theme-shadow-md);
        margin-bottom: 1.75rem;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .studio-card:hover {
        box-shadow: var(--theme-shadow-lg);
    }

    .studio-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--theme-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafbfc;
    }

    .studio-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--theme-text-main);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin: 0;
    }

    .studio-card-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--theme-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
    }

    .icon-brand { background: linear-gradient(135deg, #4f46e5, #6366f1); }
    .icon-browser { background: linear-gradient(135deg, #0284c7, #38bdf8); }
    .icon-theme { background: linear-gradient(135deg, #8b5cf6, #d946ef); }
    .icon-preview { background: linear-gradient(135deg, #059669, #10b981); }

    .studio-card-body {
        padding: 1.5rem;
    }

    /* Tabs Styling */
    .studio-tabs {
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
    }

    .studio-tab-btn {
        background: none;
        border: none;
        padding: 0.85rem 1.25rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--theme-text-muted);
        border-radius: var(--theme-radius-md) var(--theme-radius-md) 0 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        position: relative;
    }

    .studio-tab-btn:hover {
        color: var(--theme-primary);
        background: #f8fafc;
    }

    .studio-tab-btn.active {
        color: var(--theme-primary);
        background: #ffffff;
    }

    .studio-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--theme-primary);
    }

    /* Modern Dropzone & Upload Box */
    .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: var(--theme-radius-md);
        padding: 1.75rem 1.25rem;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }

    .upload-box:hover, .upload-box.dragover {
        border-color: var(--theme-primary);
        background: #f5f3ff;
        transform: translateY(-2px);
    }

    .upload-icon {
        font-size: 2.25rem;
        color: var(--theme-primary);
        margin-bottom: 0.75rem;
        transition: transform 0.2s ease;
    }

    .upload-box:hover .upload-icon {
        transform: scale(1.1);
    }

    .upload-text-main {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--theme-text-main);
        margin-bottom: 0.25rem;
    }

    .upload-text-sub {
        font-size: 0.8rem;
        color: var(--theme-text-muted);
    }

    /* Live Preview Avatar & Badge */
    .preview-avatar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: var(--theme-radius-md);
        padding: 1.25rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: var(--theme-shadow-sm);
        height: 100%;
    }

    .avatar-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        background: #ffffff;
    }

    .favicon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: var(--theme-radius-md);
        padding: 3px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        border: 1px solid #e2e8f0;
    }

    .favicon-wrapper img {
        max-width: 48px;
        max-height: 48px;
        object-fit: contain;
    }

    /* Presets Tiles */
    .preset-theme-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }

    .preset-card {
        border: 2px solid #e2e8f0;
        border-radius: var(--theme-radius-md);
        padding: 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .preset-card:hover {
        border-color: var(--theme-primary);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .preset-card.active {
        border-color: var(--theme-primary);
        background: #f5f3ff;
        box-shadow: 0 0 0 2px var(--theme-primary);
    }

    .preset-palette {
        display: flex;
        height: 28px;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 0.5rem;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
    }

    .preset-bar {
        flex: 1;
        height: 100%;
    }

    .preset-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--theme-text-main);
    }

    /* Color Swatch Grid */
    .swatch-group {
        margin-bottom: 1.5rem;
    }

    .swatch-group-label {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--theme-text-muted);
        margin-bottom: 0.65rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .swatch-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
    }

    .color-swatch-item {
        width: 44px;
        height: 44px;
        border-radius: var(--theme-radius-sm);
        border: 2px solid transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .color-swatch-item:hover {
        transform: translateY(-2px) scale(1.08);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .color-swatch-item.active {
        border-color: #ffffff;
        box-shadow: 0 0 0 3px var(--theme-primary), 0 4px 10px rgba(0,0,0,0.2);
        transform: scale(1.05);
    }

    .color-swatch-item .check-icon {
        color: #ffffff;
        font-size: 0.85rem;
        display: none;
        text-shadow: 0 1px 3px rgba(0,0,0,0.4);
    }

    .color-swatch-item.active .check-icon {
        display: block;
    }

    .color-swatch-item.light-bg .check-icon {
        color: #1e293b;
        text-shadow: none;
    }

    /* Live AdminLTE Mockup Device */
    .mockup-sticky {
        position: sticky;
        top: 80px;
    }

    .device-mockup {
        background: #0f172a;
        border-radius: var(--theme-radius-lg);
        padding: 0.75rem;
        box-shadow: var(--theme-shadow-lg);
        border: 1px solid #334155;
    }

    .mockup-tab-bar {
        background: #1e293b;
        border-radius: var(--theme-radius-sm) var(--theme-radius-sm) 0 0;
        padding: 0.45rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 1px solid #334155;
    }

    .mockup-controls {
        display: flex;
        gap: 0.3rem;
    }

    .mockup-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .mockup-dot.red { background: #ef4444; }
    .mockup-dot.yellow { background: #f59e0b; }
    .mockup-dot.green { background: #10b981; }

    .mockup-browser-tab {
        background: #334155;
        color: #f1f5f9;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.2rem 0.75rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        max-width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .mockup-browser-tab img {
        width: 14px;
        height: 14px;
        object-fit: contain;
    }

    .mockup-viewport {
        background: #f8fafc;
        border-radius: 0 0 var(--theme-radius-sm) var(--theme-radius-sm);
        height: 380px;
        display: flex;
        overflow: hidden;
        position: relative;
    }

    /* Mockup Sidebar */
    .mockup-sidebar {
        width: 105px;
        height: 100%;
        background-color: #343a40;
        color: #c2c7d0;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-right: 1px solid rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    .mockup-brand {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 0.5rem;
    }

    .mockup-brand-img {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        object-fit: cover;
    }

    .mockup-brand-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mockup-menu-item {
        padding: 0.35rem 0.45rem;
        font-size: 0.65rem;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.25rem;
        color: rgba(255,255,255,0.7);
        transition: all 0.2s;
    }

    .mockup-menu-item.active {
        color: #ffffff;
        font-weight: 700;
    }

    /* Mockup Content */
    .mockup-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .mockup-navbar {
        height: 36px;
        background-color: #343a40;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0.75rem;
        color: #ffffff;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .mockup-canvas {
        flex: 1;
        padding: 0.75rem;
        background: #f1f5f9;
        overflow-y: auto;
    }

    .mockup-card-dummy {
        background: #ffffff;
        border-radius: 6px;
        padding: 0.65rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .mockup-btn {
        display: inline-block;
        padding: 0.25rem 0.55rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
        color: #ffffff;
        background: var(--theme-primary);
        border: none;
        transition: all 0.2s ease;
    }

    /* Custom Save / Action Buttons */
    .btn-studio-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff;
        border: none;
        padding: 0.65rem 1.4rem;
        border-radius: var(--theme-radius-sm);
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        transition: all 0.2s ease;
    }

    .btn-studio-primary:hover {
        background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
        transform: translateY(-1px);
        color: #ffffff;
    }

    .btn-studio-secondary {
        background: #f1f5f9;
        color: var(--theme-text-main);
        border: 1px solid #cbd5e1;
        padding: 0.65rem 1.25rem;
        border-radius: var(--theme-radius-sm);
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-studio-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Form Controls */
    .studio-input {
        border: 1.5px solid #cbd5e1;
        border-radius: var(--theme-radius-sm);
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--theme-text-main);
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .studio-input:focus {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        outline: none;
    }

    .floating-save-bar {
        position: fixed;
        bottom: 24px;
        right: 32px;
        z-index: 1040;
        background: rgba(15, 23, 42, 0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 0.85rem 1.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        transform: translateY(120px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .floating-save-bar.visible {
        transform: translateY(0);
        opacity: 1;
    }

    /* Color definitions for Swatches */
    .c-primary { background-color: #007bff; }
    .c-secondary { background-color: #6c757d; }
    .c-info { background-color: #17a2b8; }
    .c-success { background-color: #28a745; }
    .c-danger { background-color: #dc3545; }
    .c-indigo { background-color: #6610f2; }
    .c-purple { background-color: #6f42c1; }
    .c-pink { background-color: #e83e8c; }
    .c-navy { background-color: #001f3f; }
    .c-lightblue { background-color: #3c8dbc; }
    .c-teal { background-color: #20c997; }
    .c-cyan { background-color: #17a2b8; }
    .c-darkred { background-color: #8b0000; }
    .c-gray-dark { background-color: #343a40; }
    .c-gray { background-color: #6c757d; }
    .c-dark { background-color: #1e293b; }
    .c-light { background-color: #f8f9fa; border: 1px solid #cbd5e1; }
    .c-warning { background-color: #ffc107; }
    .c-orange { background-color: #fd7e14; }

    /* =========================================================
       Dark Mode Consistency for Theme Studio & Branding
       ========================================================= */
    html.dark-mode {
        --theme-surface: #2b3035;
        --theme-border: #3f474e;
        --theme-text-main: #f8fafc;
        --theme-text-muted: #94a3b8;
    }

    body.dark-mode .custom-studio {
        color: #f8fafc;
    }

    body.dark-mode .studio-card {
        background: #2b3035;
        border-color: #3f474e;
        box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.4);
    }

    body.dark-mode .studio-card-header {
        background: #23272b;
        border-bottom-color: #3f474e;
    }

    body.dark-mode .studio-card-title {
        color: #ffffff;
    }

    body.dark-mode .studio-tabs {
        border-bottom-color: #3f474e;
    }

    body.dark-mode .studio-tab-btn {
        color: #94a3b8;
    }

    body.dark-mode .studio-tab-btn:hover {
        color: #818cf8;
        background: rgba(255, 255, 255, 0.05);
    }

    body.dark-mode .studio-tab-btn.active {
        color: #818cf8;
        background: #2b3035;
    }

    body.dark-mode .upload-box {
        background: #23272b;
        border-color: #4b5563;
    }

    body.dark-mode .upload-box:hover,
    body.dark-mode .upload-box.dragover {
        background: #1e1b4b;
        border-color: #6366f1;
    }

    body.dark-mode .upload-text-main {
        color: #f1f5f9;
    }

    body.dark-mode .upload-text-sub {
        color: #94a3b8;
    }

    body.dark-mode .preview-avatar-card {
        background: #23272b;
        border-color: #3f474e;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    body.dark-mode .avatar-wrapper img {
        background: #23272b;
    }

    body.dark-mode .favicon-wrapper {
        background: #1e2429;
        border-color: #3f474e;
    }

    body.dark-mode .preset-card {
        background: #23272b;
        border-color: #3f474e;
    }

    body.dark-mode .preset-card:hover {
        border-color: #818cf8;
        background: #2d3339;
    }

    body.dark-mode .preset-card.active {
        background: rgba(79, 70, 229, 0.2);
        border-color: #6366f1;
        box-shadow: 0 0 0 2px #6366f1;
    }

    body.dark-mode .preset-name {
        color: #f8fafc;
    }

    body.dark-mode .swatch-group-label {
        color: #cbd5e1;
    }

    body.dark-mode .studio-input {
        background: #1e2429;
        border-color: #475569;
        color: #ffffff;
    }

    body.dark-mode .studio-input:focus {
        border-color: #818cf8;
        background: #161b22;
        color: #ffffff;
    }

    body.dark-mode .input-group-text {
        background-color: #1e2429 !important;
        border-color: #475569 !important;
        color: #94a3b8 !important;
    }

    body.dark-mode .badge-light {
        background-color: #1e2429 !important;
        color: #cbd5e1 !important;
        border-color: #3f474e !important;
    }

    body.dark-mode label,
    body.dark-mode .text-dark {
        color: #f8fafc !important;
    }

    body.dark-mode .text-muted {
        color: #94a3b8 !important;
    }

    body.dark-mode hr {
        border-top-color: #3f474e;
    }

    body.dark-mode .btn-studio-secondary {
        background: #23272b;
        color: #f8fafc;
        border-color: #475569;
    }

    body.dark-mode .btn-studio-secondary:hover {
        background: #2d3339;
        color: #ffffff;
    }

    /* Live Mockup Dark Mode Styling */
    body.dark-mode .device-mockup {
        border-color: #475569;
    }

    body.dark-mode .mockup-viewport {
        background: #181d24;
    }

    body.dark-mode .mockup-canvas {
        background: #181d24;
    }

    body.dark-mode .mockup-card-dummy {
        background: #2b3035;
        border: 1px solid #3f474e;
        color: #f8fafc;
    }

    body.dark-mode .mockup-card-dummy .font-weight-bold {
        color: #f8fafc !important;
    }
</style>

<div class="custom-studio">
    <!-- Hero Header -->
    <div class="studio-header">
        <div class="studio-header-content">
            <div class="studio-badge">
                <span class="status-dot"></span>
                Theme Studio & Branding
            </div>
            <h1 class="font-weight-bold mb-2" style="font-size: 2.15rem; letter-spacing: -0.02em;">Customize Appearance</h1>
            <p class="text-white-50 mb-0" style="max-width: 650px; font-size: 1rem; line-height: 1.5;">
                Personalize your school brand, browser tab identity, and AdminLTE navigation themes. Test changes in the real-time interactive preview before saving.
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row">
        <!-- Studio Configuration Left Column -->
        <div class="col-xl-8 col-lg-7">
            <!-- Studio Tabs Navigation -->
            <div class="studio-tabs">
                <button class="studio-tab-btn active" data-tab="brand">
                    <i class="fas fa-graduation-cap"></i> Brand Identity
                </button>
                <button class="studio-tab-btn" data-tab="browser">
                    <i class="fas fa-globe"></i> Browser & SEO
                </button>
                <button class="studio-tab-btn" data-tab="theme">
                    <i class="fas fa-palette"></i> Themes & Colors
                </button>
            </div>

            <!-- TAB 1: BRAND IDENTITY -->
            <div id="tab-brand" class="studio-tab-pane">
                <div class="studio-card">
                    <div class="studio-card-header">
                        <h4 class="studio-card-title">
                            <span class="studio-card-icon icon-brand"><i class="fas fa-school"></i></span>
                            School Brand Logo & Title
                        </h4>
                        <span class="badge badge-light border">Sidebar & Header Identity</span>
                    </div>
                    <div class="studio-card-body">
                        <div class="row align-items-center mb-4">
                            <!-- Logo Preview Avatar -->
                            <div class="col-sm-4 text-center mb-3 mb-sm-0">
                                <div class="preview-avatar-card">
                                    <div class="avatar-wrapper">
                                        <img id="current-logo-img"
                                             src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}"
                                             alt="School Brand Logo">
                                    </div>
                                    <div class="font-weight-bold text-dark small mb-1">Active Logo</div>
                                    <span class="text-muted small">JPG, PNG, GIF, ICO</span>
                                </div>
                            </div>

                            <!-- Logo Drag and Drop Box -->
                            <div class="col-sm-8">
                                <input type="file" id="logoFileInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/x-icon,image/webp,image/svg+xml" style="display: none;">
                                <div class="upload-box" id="logoUploadBox" title="Click or drag and drop to change logo">
                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="upload-text-main" id="logoUploadText">Choose an image or drag & drop here</div>
                                    <div class="upload-text-sub">Maximum file size: 4MB. Square 1:1 recommended (PNG, JPG, SVG, WEBP, ICO)</div>
                                    <div id="logoUploadProgress" class="progress mt-3 d-none" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="small text-muted" id="logoUploadStatusText"><i class="fas fa-info-circle mr-1"></i>Select an image to automatically update logo</span>
                                    <button id="btnSaveLogo" class="btn btn-sm btn-studio-primary d-none">
                                        <i class="fas fa-upload mr-1"></i> Upload Selected Logo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Brand Title Input -->
                        <div class="form-group mb-0">
                            <label for="brandTitleInput" class="font-weight-bold text-dark mb-1">
                                Brand Title (School Name)
                            </label>
                            <p class="text-muted small mb-2">This name appears alongside the logo in the sidebar header and top menus.</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-heading text-muted"></i></span>
                                </div>
                                <input type="text" id="brandTitleInput" class="form-control studio-input"
                                       value="{{ $customizes->brand_title ?? 'School System' }}"
                                       placeholder="e.g. Mawarid Academy" maxlength="255">
                                <div class="input-group-append">
                                    <button id="updateBrandTitleBtn" class="btn btn-studio-primary">
                                        <i class="fas fa-save"></i> Save Title
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: BROWSER & SEO -->
            <div id="tab-browser" class="studio-tab-pane d-none">
                <div class="studio-card">
                    <div class="studio-card-header">
                        <h4 class="studio-card-title">
                            <span class="studio-card-icon icon-browser"><i class="fas fa-window-maximize"></i></span>
                            Browser Tab Icon & Title
                        </h4>
                        <span class="badge badge-light border">Favicon & SEO Heading</span>
                    </div>
                    <div class="studio-card-body">
                        <div class="row align-items-center mb-4">
                            <!-- Favicon Preview -->
                            <div class="col-sm-4 text-center mb-3 mb-sm-0">
                                <div class="preview-avatar-card">
                                    <div class="favicon-wrapper">
                                        <img id="current-icon-img"
                                             src="{{ asset($customizes->url_icon ?? 'favicon.ico') }}"
                                             alt="Favicon">
                                    </div>
                                    <div class="font-weight-bold text-dark small mb-1">Active Favicon</div>
                                    <span class="text-muted small">favicon.ico / PNG</span>
                                </div>
                            </div>

                            <!-- Favicon Upload Box -->
                            <div class="col-sm-8">
                                <input type="file" id="iconFileInput" accept="image/x-icon,image/png,image/jpeg,image/jpg,image/gif,image/webp,image/svg+xml" style="display: none;">
                                <div class="upload-box" id="iconUploadBox" title="Click or drag and drop to change favicon">
                                    <div class="upload-icon text-info"><i class="fas fa-file-image"></i></div>
                                    <div class="upload-text-main" id="iconUploadText">Upload New Browser Favicon</div>
                                    <div class="upload-text-sub">Recommended: .ico, transparent PNG or SVG (max 4MB)</div>
                                    <div id="iconUploadProgress" class="progress mt-3 d-none" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="small text-muted" id="iconUploadStatusText"><i class="fas fa-info-circle mr-1"></i>Select an icon to automatically update browser tab</span>
                                    <button id="btnSaveIcon" class="btn btn-sm btn-studio-primary d-none">
                                        <i class="fas fa-upload mr-1"></i> Upload Selected Icon
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- URL Title Input -->
                        <div class="form-group mb-0">
                            <label for="urlTitleInput" class="font-weight-bold text-dark mb-1">
                                Browser Page Title
                            </label>
                            <p class="text-muted small mb-2">The title displayed on browser tabs, bookmarks, and search results.</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-globe text-muted"></i></span>
                                </div>
                                <input type="text" id="urlTitleInput" class="form-control studio-input"
                                       value="{{ $customizes->url_title ?? 'School Management System' }}"
                                       placeholder="e.g. Mawarid Academy - School Portal" maxlength="255">
                                <div class="input-group-append">
                                    <button id="updateURLTitleBtn" class="btn btn-studio-primary">
                                        <i class="fas fa-save"></i> Save Page Title
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: THEMES & COLORS -->
            <div id="tab-theme" class="studio-tab-pane d-none">
                <div class="studio-card">
                    <div class="studio-card-header">
                        <h4 class="studio-card-title">
                            <span class="studio-card-icon icon-theme"><i class="fas fa-paint-brush"></i></span>
                            Theme Studio & Color Palette
                        </h4>
                        <span class="badge badge-light border">Live UI Synchronization</span>
                    </div>
                    <div class="studio-card-body">
                        <!-- Preset Color Themes -->
                        <div class="mb-4">
                            <div class="swatch-group-label">
                                <i class="fas fa-magic text-primary"></i> One-Click Curated Presets
                            </div>
                            <div class="preset-theme-grid">
                                <div class="preset-card" data-preset="indigo">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #001f3f;"></span>
                                        <span class="preset-bar" style="background: #6610f2;"></span>
                                        <span class="preset-bar" style="background: #6610f2;"></span>
                                    </div>
                                    <div class="preset-name">Indigo Royal</div>
                                </div>

                                <div class="preset-card" data-preset="emerald">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #1e293b;"></span>
                                        <span class="preset-bar" style="background: #20c997;"></span>
                                        <span class="preset-bar" style="background: #20c997;"></span>
                                    </div>
                                    <div class="preset-name">Emerald Campus</div>
                                </div>

                                <div class="preset-card" data-preset="crimson">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #343a40;"></span>
                                        <span class="preset-bar" style="background: #dc3545;"></span>
                                        <span class="preset-bar" style="background: #dc3545;"></span>
                                    </div>
                                    <div class="preset-name">Crimson Academy</div>
                                </div>

                                <div class="preset-card" data-preset="midnight">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #1e293b;"></span>
                                        <span class="preset-bar" style="background: #343a40;"></span>
                                        <span class="preset-bar" style="background: #3c8dbc;"></span>
                                    </div>
                                    <div class="preset-name">Midnight Slate</div>
                                </div>

                                <div class="preset-card" data-preset="oceanic">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #001f3f;"></span>
                                        <span class="preset-bar" style="background: #17a2b8;"></span>
                                        <span class="preset-bar" style="background: #17a2b8;"></span>
                                    </div>
                                    <div class="preset-name">Oceanic Cyan</div>
                                </div>

                                <div class="preset-card" data-preset="classic">
                                    <div class="preset-palette">
                                        <span class="preset-bar" style="background: #343a40;"></span>
                                        <span class="preset-bar" style="background: #007bff;"></span>
                                        <span class="preset-bar" style="background: #007bff;"></span>
                                    </div>
                                    <div class="preset-name">Classic Blue</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- 1. Navbar Theme Color Swatches -->
                        <div class="swatch-group">
                            <div class="swatch-group-label">
                                <i class="fas fa-window-minimize"></i> Top Navbar Background Color
                            </div>
                            <div class="swatch-grid" id="navbarSwatches">
                                <div class="color-swatch-item c-primary" data-val="bg-primary" title="Primary Blue"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-indigo" data-val="bg-indigo" title="Indigo"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-navy" data-val="bg-navy" title="Deep Navy"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-purple" data-val="bg-purple" title="Royal Purple"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-teal" data-val="bg-teal" title="Teal"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-cyan" data-val="bg-cyan" title="Cyan"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-success" data-val="bg-success" title="Success Green"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-danger" data-val="bg-danger" title="Danger Red"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-darkred" data-val="bg-darkred" title="Dark Red"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-orange" data-val="bg-orange" title="Sunset Orange"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-warning light-bg" data-val="bg-warning" title="Warning Amber"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-pink" data-val="bg-pink" title="Pink"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-lightblue" data-val="bg-lightblue" title="Light Blue"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-dark" data-val="bg-dark" title="Dark Slate"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-gray-dark" data-val="bg-gray-dark" title="Gray Dark"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-secondary" data-val="bg-secondary" title="Secondary"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-light light-bg" data-val="bg-light" title="Clean Light"><i class="fas fa-check check-icon"></i></div>
                            </div>
                        </div>

                        <!-- 2. Sidebar Background Color Swatches -->
                        <div class="swatch-group">
                            <div class="swatch-group-label">
                                <i class="fas fa-columns"></i> Sidebar Background Base
                            </div>
                            <div class="swatch-grid" id="sidebarSwatches">
                                <div class="color-swatch-item c-dark" data-val="bg-dark" title="Dark"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-navy" data-val="bg-navy" title="Deep Navy"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-indigo" data-val="bg-indigo" title="Indigo"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-gray-dark" data-val="bg-gray-dark" title="Gray Dark"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-primary" data-val="bg-primary" title="Primary Blue"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-teal" data-val="bg-teal" title="Teal"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-purple" data-val="bg-purple" title="Purple"><i class="fas fa-check check-icon"></i></div>
                            </div>
                        </div>

                        <!-- 3. Dark Sidebar Variants -->
                        <div class="swatch-group">
                            <div class="swatch-group-label">
                                <i class="fas fa-bars"></i> Sidebar Navigation Highlight Variant
                            </div>
                            <div class="swatch-grid" id="variantSwatches">
                                <div class="color-swatch-item c-primary" data-val="sidebar-dark-primary" title="Dark Primary"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-indigo" data-val="sidebar-dark-indigo" title="Dark Indigo"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-navy" data-val="sidebar-dark-navy" title="Dark Navy"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-teal" data-val="sidebar-dark-teal" title="Dark Teal"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-success" data-val="sidebar-dark-success" title="Dark Success"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-danger" data-val="sidebar-dark-danger" title="Dark Danger"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-warning light-bg" data-val="sidebar-dark-warning" title="Dark Warning"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-purple" data-val="sidebar-dark-purple" title="Dark Purple"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-cyan" data-val="sidebar-dark-cyan" title="Dark Cyan"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-light light-bg" data-val="sidebar-light-primary" title="Light Primary"><i class="fas fa-check check-icon"></i></div>
                            </div>
                        </div>

                        <!-- 4. Global Accent Highlights -->
                        <div class="swatch-group mb-4">
                            <div class="swatch-group-label">
                                <i class="fas fa-highlighter"></i> Global Accent Highlights
                            </div>
                            <div class="swatch-grid" id="accentSwatches">
                                <div class="color-swatch-item c-light light-bg" data-val="" title="Default"><i class="fas fa-ban check-icon"></i></div>
                                <div class="color-swatch-item c-primary" data-val="accent-primary" title="Accent Primary"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-indigo" data-val="accent-indigo" title="Accent Indigo"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-navy" data-val="accent-navy" title="Accent Navy"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-teal" data-val="accent-teal" title="Accent Teal"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-cyan" data-val="accent-cyan" title="Accent Cyan"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-success" data-val="accent-success" title="Accent Success"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-danger" data-val="accent-danger" title="Accent Danger"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-purple" data-val="accent-purple" title="Accent Purple"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-pink" data-val="accent-pink" title="Accent Pink"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-warning light-bg" data-val="accent-warning" title="Accent Warning"><i class="fas fa-check check-icon"></i></div>
                                <div class="color-swatch-item c-orange" data-val="accent-orange" title="Accent Orange"><i class="fas fa-check check-icon"></i></div>
                            </div>
                        </div>

                        <!-- Save Theme Action -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <button id="btnResetTheme" class="btn btn-studio-secondary">
                                <i class="fas fa-undo"></i> Reset to Defaults
                            </button>
                            <button id="saveThemeBtn" class="btn btn-studio-primary">
                                <i class="fas fa-save"></i> Save Theme Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Real-Time Preview Right Column -->
        <div class="col-xl-4 col-lg-5">
            <div class="mockup-sticky">
                <div class="device-mockup">
                    <!-- Browser Tab Bar Mockup -->
                    <div class="mockup-tab-bar">
                        <div class="mockup-controls">
                            <span class="mockup-dot red"></span>
                            <span class="mockup-dot yellow"></span>
                            <span class="mockup-dot green"></span>
                        </div>
                        <div class="mockup-browser-tab">
                            <img id="mockup-favicon" src="{{ asset($customizes->url_icon ?? 'favicon.ico') }}" alt="Tab Icon">
                            <span id="mockup-url-title">{{ $customizes->url_title ?? 'School System' }}</span>
                        </div>
                    </div>

                    <!-- Mini Viewport Mockup -->
                    <div class="mockup-viewport">
                        <!-- Mockup Sidebar -->
                        <div class="mockup-sidebar" id="mockupSidebar">
                            <div class="mockup-brand">
                                <img id="mockup-brand-logo" class="mockup-brand-img"
                                     src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}"
                                     alt="Logo">
                                <span id="mockup-brand-title" class="mockup-brand-title">{{ $customizes->brand_title ?? 'School' }}</span>
                            </div>

                            <div class="mockup-menu-item active" id="mockupActiveMenuItem" style="background: rgba(255,255,255,0.15);">
                                <i class="fas fa-tachometer-alt" style="font-size: 0.6rem;"></i>
                                <span>Dashboard</span>
                            </div>
                            <div class="mockup-menu-item">
                                <i class="fas fa-user-graduate" style="font-size: 0.6rem;"></i>
                                <span>Students</span>
                            </div>
                            <div class="mockup-menu-item">
                                <i class="fas fa-chalkboard-teacher" style="font-size: 0.6rem;"></i>
                                <span>Teachers</span>
                            </div>
                            <div class="mockup-menu-item">
                                <i class="fas fa-book" style="font-size: 0.6rem;"></i>
                                <span>Classes</span>
                            </div>
                            <div class="mockup-menu-item">
                                <i class="fas fa-calendar-alt" style="font-size: 0.6rem;"></i>
                                <span>Routine</span>
                            </div>
                            <div class="mockup-menu-item">
                                <i class="fas fa-chart-line" style="font-size: 0.6rem;"></i>
                                <span>Reports</span>
                            </div>
                        </div>

                        <!-- Mockup Content View -->
                        <div class="mockup-main">
                            <!-- Mockup Navbar -->
                            <div class="mockup-navbar" id="mockupNavbar">
                                <div><i class="fas fa-bars"></i></div>
                                <div class="d-flex align-items-center" style="gap: 0.6rem;">
                                    <i class="fas fa-bell"></i>
                                    <i class="fas fa-expand-arrows-alt"></i>
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            </div>

                            <!-- Mockup Canvas -->
                            <div class="mockup-canvas">
                                <div class="mockup-card-dummy d-flex justify-content-between align-items-center">
                                    <div>
                                        <div style="font-size: 0.7rem; font-weight: 700; color: #1e293b;">Active Enrollment</div>
                                        <div style="font-size: 0.6rem; color: #64748b;">1,420 Students</div>
                                    </div>
                                    <button class="mockup-btn" id="mockupAccentBtn">View</button>
                                </div>

                                <div class="mockup-card-dummy">
                                    <div style="font-size: 0.65rem; font-weight: 700; color: #1e293b; margin-bottom: 0.3rem;">Campus Activity</div>
                                    <div class="progress" style="height: 4px; margin-bottom: 0.3rem;">
                                        <div class="progress-bar bg-success" style="width: 78%"></div>
                                    </div>
                                    <span class="badge badge-primary" style="font-size: 0.55rem;">Live Sync</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3 border-0 shadow-sm" style="border-radius: var(--theme-radius-md); background: #f8fafc;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fas fa-info-circle text-primary mr-2" style="font-size: 1.1rem;"></i>
                            <span>
                                Live preview reflects your changes instantly. Click <strong>Save Settings</strong> to apply your custom design across the entire application.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Quick-Save Bar -->
<div class="floating-save-bar" id="floatingSaveBar">
    <div class="d-flex align-items-center">
        <i class="fas fa-pen-nib text-warning mr-2"></i>
        <span class="small font-weight-bold">Unsaved theme customizations</span>
    </div>
    <div class="d-flex" style="gap: 0.5rem;">
        <button id="btnFloatingDiscard" class="btn btn-sm btn-outline-light rounded-pill px-3">Discard</button>
        <button id="btnFloatingSave" class="btn btn-sm btn-primary rounded-pill px-3">Save All</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Current Active Customization Values
    let themeState = {
        nav_color: "{{ $customizes->nav_color ?? 'bg-primary' }}",
        sidebar_color: "{{ $customizes->sidebar_color ?? 'bg-dark' }}",
        dark_sidebar_variants: "{{ $customizes->dark_sidebar_variants ?? 'sidebar-dark-primary' }}",
        accent_color: "{{ $customizes->accent_color ?? '' }}"
    };

    let hasUnsavedChanges = false;
    const floatingBar = document.getElementById("floatingSaveBar");

    function markChanged() {
        hasUnsavedChanges = true;
        floatingBar.classList.add("visible");
    }

    function markSaved() {
        hasUnsavedChanges = false;
        floatingBar.classList.remove("visible");
    }

    // Helper: Toast alerts using SweetAlert2
    function showToast(icon, title) {
        if (typeof Swal !== "undefined") {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } else {
            alert(title);
        }
    }

    // Tab Navigation Logic
    const tabBtns = document.querySelectorAll(".studio-tab-btn");
    const tabPanes = document.querySelectorAll(".studio-tab-pane");

    tabBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            const targetTab = this.getAttribute("data-tab");
            tabBtns.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            tabPanes.forEach(pane => {
                if (pane.id === "tab-" + targetTab) {
                    pane.classList.remove("d-none");
                } else {
                    pane.classList.add("d-none");
                }
            });
        });
    });

    // -------------------------------------------------------------
    // BRAND TITLE SYNC & SAVE
    // -------------------------------------------------------------
    const brandInput = document.getElementById("brandTitleInput");
    const mockupBrandTitle = document.getElementById("mockup-brand-title");

    brandInput.addEventListener("input", function () {
        const val = this.value.trim() || "School";
        mockupBrandTitle.textContent = val;
        // Live sync with real sidebar brand text if exists
        const realBrand = document.querySelector(".brand-text");
        if (realBrand) realBrand.textContent = val;
    });

    document.getElementById("updateBrandTitleBtn").addEventListener("click", function () {
        const newTitle = brandInput.value.trim();
        if (!newTitle) {
            showToast("warning", "Brand title cannot be empty!");
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        fetch("{{ route('customize.updateBrandTitle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ brand_title: newTitle })
        })
        .then(res => res.json())
        .then(data => {
            showToast("success", data.message || "Brand Title Updated!");
        })
        .catch(err => {
            console.error(err);
            showToast("error", "Failed to update brand title.");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Save Title';
        });
    });

    // -------------------------------------------------------------
    // URL TITLE (BROWSER TAB) SYNC & SAVE
    // -------------------------------------------------------------
    const urlTitleInput = document.getElementById("urlTitleInput");
    const mockupUrlTitle = document.getElementById("mockup-url-title");

    urlTitleInput.addEventListener("input", function () {
        const val = this.value.trim() || "School System";
        mockupUrlTitle.textContent = val;
        document.title = val;
    });

    document.getElementById("updateURLTitleBtn").addEventListener("click", function () {
        const newTitle = urlTitleInput.value.trim();
        if (!newTitle) {
            showToast("warning", "Page title cannot be empty!");
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        fetch("{{ route('customize.updateURLTitle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ url_title: newTitle })
        })
        .then(res => res.json())
        .then(data => {
            showToast("success", data.message || "Page Title Updated!");
        })
        .catch(err => {
            console.error(err);
            showToast("error", "Failed to update page title.");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Save Page Title';
        });
    });

    // -------------------------------------------------------------
    // LOGO UPLOAD (AUTO-UPLOAD ON CHANGE/DROP + LIVE PREVIEW)
    // -------------------------------------------------------------
    const logoUploadBox = document.getElementById("logoUploadBox");
    const logoFileInput = document.getElementById("logoFileInput");
    const btnSaveLogo = document.getElementById("btnSaveLogo");
    const logoUploadText = document.getElementById("logoUploadText");
    const logoProgressBar = document.getElementById("logoUploadProgress");

    logoUploadBox.addEventListener("click", () => logoFileInput.click());

    logoUploadBox.addEventListener("dragover", e => {
        e.preventDefault();
        logoUploadBox.classList.add("dragover");
    });

    logoUploadBox.addEventListener("dragleave", () => {
        logoUploadBox.classList.remove("dragover");
    });

    logoUploadBox.addEventListener("drop", e => {
        e.preventDefault();
        logoUploadBox.classList.remove("dragover");
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            logoFileInput.files = e.dataTransfer.files;
            uploadLogoFile(e.dataTransfer.files[0]);
        }
    });

    logoFileInput.addEventListener("change", function () {
        if (this.files && this.files.length > 0) {
            uploadLogoFile(this.files[0]);
        }
    });

    btnSaveLogo.addEventListener("click", function () {
        if (logoFileInput.files && logoFileInput.files.length > 0) {
            uploadLogoFile(logoFileInput.files[0]);
        } else {
            logoFileInput.click();
        }
    });

    function uploadLogoFile(file) {
        if (!file) return;

        if (file.size > 4 * 1024 * 1024) {
            showToast("warning", "Image must be under 4MB!");
            logoFileInput.value = "";
            return;
        }

        // Instant local preview
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewUrl = e.target.result;
            const logoImg = document.getElementById("current-logo-img");
            if (logoImg) logoImg.src = previewUrl;
            const mockLogo = document.getElementById("mockup-brand-logo");
            if (mockLogo) mockLogo.src = previewUrl;
            document.querySelectorAll(".brand-image, .preloader-brand-img").forEach(img => img.src = previewUrl);
        };
        reader.readAsDataURL(file);

        // UI upload state
        logoUploadText.innerHTML = `<i class="fas fa-spinner fa-spin mr-1"></i> Uploading <strong>${file.name}</strong>...`;
        logoProgressBar.classList.remove("d-none");
        btnSaveLogo.classList.remove("d-none");
        btnSaveLogo.disabled = true;
        btnSaveLogo.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

        const formData = new FormData();
        formData.append("file", file);

        fetch("{{ route('customize.updateLogo') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const errorMsg = data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : "Upload failed");
                throw new Error(errorMsg);
            }
            return data;
        })
        .then(data => {
            showToast("success", data.message || "Brand Logo Updated Successfully!");
            if (data.newLogoUrl) {
                const logoImg = document.getElementById("current-logo-img");
                if (logoImg) logoImg.src = data.newLogoUrl;
                const mockLogo = document.getElementById("mockup-brand-logo");
                if (mockLogo) mockLogo.src = data.newLogoUrl;
                document.querySelectorAll(".brand-image, .preloader-brand-img").forEach(img => img.src = data.newLogoUrl);
            }
            logoUploadText.innerHTML = `<span class="text-success"><i class="fas fa-check-circle mr-1"></i> ${file.name} saved!</span>`;
            setTimeout(() => {
                logoUploadText.textContent = "Choose an image or drag & drop here";
            }, 3000);
            btnSaveLogo.classList.add("d-none");
            logoFileInput.value = "";
        })
        .catch(err => {
            console.error("Logo upload error:", err);
            showToast("error", err.message || "Error uploading logo. Please try again.");
            logoUploadText.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Upload failed. Try again.</span>`;
            btnSaveLogo.classList.remove("d-none");
            btnSaveLogo.disabled = false;
            btnSaveLogo.innerHTML = '<i class="fas fa-redo mr-1"></i> Retry Upload';
        })
        .finally(() => {
            logoProgressBar.classList.add("d-none");
        });
    }

    // -------------------------------------------------------------
    // FAVICON UPLOAD (AUTO-UPLOAD ON CHANGE/DROP + BROWSER TAB SYNC)
    // -------------------------------------------------------------
    const iconUploadBox = document.getElementById("iconUploadBox");
    const iconFileInput = document.getElementById("iconFileInput");
    const btnSaveIcon = document.getElementById("btnSaveIcon");
    const iconUploadText = document.getElementById("iconUploadText");
    const iconProgressBar = document.getElementById("iconUploadProgress");

    iconUploadBox.addEventListener("click", () => iconFileInput.click());

    iconUploadBox.addEventListener("dragover", e => {
        e.preventDefault();
        iconUploadBox.classList.add("dragover");
    });

    iconUploadBox.addEventListener("dragleave", () => {
        iconUploadBox.classList.remove("dragover");
    });

    iconUploadBox.addEventListener("drop", e => {
        e.preventDefault();
        iconUploadBox.classList.remove("dragover");
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            iconFileInput.files = e.dataTransfer.files;
            uploadIconFile(e.dataTransfer.files[0]);
        }
    });

    iconFileInput.addEventListener("change", function () {
        if (this.files && this.files.length > 0) {
            uploadIconFile(this.files[0]);
        }
    });

    btnSaveIcon.addEventListener("click", function () {
        if (iconFileInput.files && iconFileInput.files.length > 0) {
            uploadIconFile(iconFileInput.files[0]);
        } else {
            iconFileInput.click();
        }
    });

    function uploadIconFile(file) {
        if (!file) return;

        if (file.size > 4 * 1024 * 1024) {
            showToast("warning", "Icon must be under 4MB!");
            iconFileInput.value = "";
            return;
        }

        // Instant local preview
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewUrl = e.target.result;
            const iconImg = document.getElementById("current-icon-img");
            if (iconImg) iconImg.src = previewUrl;
            const mockFavicon = document.getElementById("mockup-favicon");
            if (mockFavicon) mockFavicon.src = previewUrl;

            // Immediately update the live browser tab icon
            let fav = document.querySelector("link[rel*='icon']");
            if (fav) fav.href = previewUrl;
        };
        reader.readAsDataURL(file);

        // UI upload state
        iconUploadText.innerHTML = `<i class="fas fa-spinner fa-spin mr-1"></i> Uploading <strong>${file.name}</strong>...`;
        iconProgressBar.classList.remove("d-none");
        btnSaveIcon.classList.remove("d-none");
        btnSaveIcon.disabled = true;
        btnSaveIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

        const formData = new FormData();
        formData.append("file", file);

        fetch("{{ route('customize.updateIcon') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const errorMsg = data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : "Upload failed");
                throw new Error(errorMsg);
            }
            return data;
        })
        .then(data => {
            showToast("success", data.message || "Browser Tab Icon Updated Successfully!");
            if (data.newIconUrl) {
                const iconImg = document.getElementById("current-icon-img");
                if (iconImg) iconImg.src = data.newIconUrl;
                const mockFavicon = document.getElementById("mockup-favicon");
                if (mockFavicon) mockFavicon.src = data.newIconUrl;

                // Update document <link rel="icon">
                let fav = document.querySelector("link[rel*='icon']");
                if (!fav) {
                    fav = document.createElement("link");
                    fav.rel = "icon";
                    document.head.appendChild(fav);
                }
                fav.href = data.newIconUrl;
            }
            iconUploadText.innerHTML = `<span class="text-success"><i class="fas fa-check-circle mr-1"></i> ${file.name} saved!</span>`;
            setTimeout(() => {
                iconUploadText.textContent = "Upload New Browser Favicon";
            }, 3000);
            btnSaveIcon.classList.add("d-none");
            iconFileInput.value = "";
        })
        .catch(err => {
            console.error("Icon upload error:", err);
            showToast("error", err.message || "Error uploading icon. Please try again.");
            iconUploadText.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> Upload failed. Try again.</span>`;
            btnSaveIcon.classList.remove("d-none");
            btnSaveIcon.disabled = false;
            btnSaveIcon.innerHTML = '<i class="fas fa-redo mr-1"></i> Retry Upload';
        })
        .finally(() => {
            iconProgressBar.classList.add("d-none");
        });
    }

    // -------------------------------------------------------------
    // LIVE COLOR APPLICATOR & REAL-TIME PREVIEW
    // -------------------------------------------------------------
    const navbarMain = document.getElementById("mainNav");
    const bodyMain = document.getElementById("mainBody");
    const sidebarMain = document.querySelector(".main-sidebar");

    const mockupNavbar = document.getElementById("mockupNavbar");
    const mockupSidebar = document.getElementById("mockupSidebar");
    const mockupAccentBtn = document.getElementById("mockupAccentBtn");

    function applyNavbarColor(cls) {
        themeState.nav_color = cls;

        // Apply to Real AdminLTE Navbar
        if (navbarMain) {
            const removeList = [];
            navbarMain.classList.forEach(c => {
                if (c.startsWith("bg-") || c.startsWith("navbar-light") || c.startsWith("navbar-white")) {
                    removeList.push(c);
                }
            });
            removeList.forEach(c => navbarMain.classList.remove(c));

            if (cls === "bg-light") {
                navbarMain.classList.add("navbar-light", "bg-light");
                navbarMain.classList.remove("navbar-dark");
            } else {
                navbarMain.classList.add("navbar-dark", cls);
                navbarMain.classList.remove("navbar-light");
            }
        }

        // Apply to Mockup
        mockupNavbar.className = "mockup-navbar " + cls;

        // Highlight Active Swatch
        document.querySelectorAll("#navbarSwatches .color-swatch-item").forEach(item => {
            item.classList.toggle("active", item.getAttribute("data-val") === cls);
        });
    }

    function applySidebarColor(cls) {
        themeState.sidebar_color = cls;

        if (sidebarMain) {
            const removeList = [];
            sidebarMain.classList.forEach(c => {
                if (c.startsWith("bg-")) removeList.push(c);
            });
            removeList.forEach(c => sidebarMain.classList.remove(c));
            if (cls) sidebarMain.classList.add(cls);
        }

        mockupSidebar.className = "mockup-sidebar " + cls;

        document.querySelectorAll("#sidebarSwatches .color-swatch-item").forEach(item => {
            item.classList.toggle("active", item.getAttribute("data-val") === cls);
        });
    }

    function applySidebarVariant(cls) {
        themeState.dark_sidebar_variants = cls;

        if (sidebarMain) {
            const removeList = [];
            sidebarMain.classList.forEach(c => {
                if (c.startsWith("sidebar-dark-") || c.startsWith("sidebar-light-")) removeList.push(c);
            });
            removeList.forEach(c => sidebarMain.classList.remove(c));
            if (cls) sidebarMain.classList.add(cls);
        }

        if (typeof window.syncSidebarScrollbarTheme === 'function') {
            window.syncSidebarScrollbarTheme();
        } else {
            const sidebarEl = document.querySelector('.main-sidebar .sidebar');
            if (sidebarEl) {
                if (cls && cls.startsWith('sidebar-light-')) {
                    sidebarEl.classList.remove('os-theme-light');
                    sidebarEl.classList.add('os-theme-dark');
                } else {
                    sidebarEl.classList.remove('os-theme-dark');
                    sidebarEl.classList.add('os-theme-light');
                }
            }
        }

        document.querySelectorAll("#variantSwatches .color-swatch-item").forEach(item => {
            item.classList.toggle("active", item.getAttribute("data-val") === cls);
        });
    }

    function applyAccentColor(cls) {
        themeState.accent_color = cls;

        if (bodyMain) {
            const removeList = [];
            bodyMain.classList.forEach(c => {
                if (c.startsWith("accent-")) removeList.push(c);
            });
            removeList.forEach(c => bodyMain.classList.remove(c));
            if (cls) bodyMain.classList.add(cls);
        }

        // Apply accent color to Mockup Button
        if (cls) {
            const colorName = cls.replace("accent-", "");
            mockupAccentBtn.className = "mockup-btn bg-" + colorName;
        } else {
            mockupAccentBtn.className = "mockup-btn bg-primary";
        }

        document.querySelectorAll("#accentSwatches .color-swatch-item").forEach(item => {
            item.classList.toggle("active", item.getAttribute("data-val") === cls);
        });
    }

    // Swatch Click Listeners
    document.querySelectorAll("#navbarSwatches .color-swatch-item").forEach(item => {
        item.addEventListener("click", function () {
            applyNavbarColor(this.getAttribute("data-val"));
            markChanged();
        });
    });

    document.querySelectorAll("#sidebarSwatches .color-swatch-item").forEach(item => {
        item.addEventListener("click", function () {
            applySidebarColor(this.getAttribute("data-val"));
            markChanged();
        });
    });

    document.querySelectorAll("#variantSwatches .color-swatch-item").forEach(item => {
        item.addEventListener("click", function () {
            applySidebarVariant(this.getAttribute("data-val"));
            markChanged();
        });
    });

    document.querySelectorAll("#accentSwatches .color-swatch-item").forEach(item => {
        item.addEventListener("click", function () {
            applyAccentColor(this.getAttribute("data-val"));
            markChanged();
        });
    });

    // Preset Themes
    const presets = {
        indigo: { nav: "bg-indigo", side: "bg-navy", variant: "sidebar-dark-indigo", accent: "accent-indigo" },
        emerald: { nav: "bg-teal", side: "bg-dark", variant: "sidebar-dark-teal", accent: "accent-teal" },
        crimson: { nav: "bg-danger", side: "bg-gray-dark", variant: "sidebar-dark-danger", accent: "accent-danger" },
        midnight: { nav: "bg-gray-dark", side: "bg-dark", variant: "sidebar-dark-lightblue", accent: "accent-lightblue" },
        oceanic: { nav: "bg-cyan", side: "bg-navy", variant: "sidebar-dark-cyan", accent: "accent-cyan" },
        classic: { nav: "bg-primary", side: "bg-dark", variant: "sidebar-dark-primary", accent: "accent-primary" }
    };

    document.querySelectorAll(".preset-card").forEach(card => {
        card.addEventListener("click", function () {
            const pKey = this.getAttribute("data-preset");
            const p = presets[pKey];
            if (!p) return;

            document.querySelectorAll(".preset-card").forEach(c => c.classList.remove("active"));
            this.classList.add("active");

            applyNavbarColor(p.nav);
            applySidebarColor(p.side);
            applySidebarVariant(p.variant);
            applyAccentColor(p.accent);
            markChanged();
        });
    });

    // Reset Defaults Button
    document.getElementById("btnResetTheme")?.addEventListener("click", function () {
        applyNavbarColor("bg-primary");
        applySidebarColor("bg-dark");
        applySidebarVariant("sidebar-dark-primary");
        applyAccentColor("");
        markChanged();
        showToast("info", "Reset to default AdminLTE styling.");
    });

    // -------------------------------------------------------------
    // SAVE THEME FUNCTION
    // -------------------------------------------------------------
    async function saveThemeSettings() {
        const saveBtns = [document.getElementById("saveThemeBtn"), document.getElementById("btnFloatingSave")];
        saveBtns.forEach(btn => {
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
        });

        try {
            const response = await fetch("{{ route('customize.updateTheme') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    nav_color: themeState.nav_color,
                    accent_color: themeState.accent_color,
                    sidebar_color: themeState.sidebar_color,
                    dark_sidebar_variants: themeState.dark_sidebar_variants
                })
            });

            const data = await response.json();
            if (data.success) {
                markSaved();
                showToast("success", "Theme Customizations Saved Successfully!");
            } else {
                showToast("error", "Failed to save theme settings.");
            }
        } catch (error) {
            console.error("Error updating theme:", error);
            showToast("error", "Error saving theme settings.");
        } finally {
            saveBtns.forEach(btn => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> Save Theme Settings';
                }
            });
            const floatBtn = document.getElementById("btnFloatingSave");
            if (floatBtn) floatBtn.innerHTML = "Save All";
        }
    }

    document.getElementById("saveThemeBtn")?.addEventListener("click", saveThemeSettings);
    document.getElementById("btnFloatingSave")?.addEventListener("click", saveThemeSettings);

    document.getElementById("btnFloatingDiscard")?.addEventListener("click", function () {
        markSaved();
        location.reload();
    });

    // Initialize Active Swatches from Database
    (async function initTheme() {
        try {
            const res = await fetch("{{ route('customize.getTheme') }}");
            const data = await res.json();
            if (data.nav_color) applyNavbarColor(data.nav_color);
            else applyNavbarColor(themeState.nav_color);

            if (data.sidebar_color) applySidebarColor(data.sidebar_color);
            else applySidebarColor(themeState.sidebar_color);

            if (data.dark_sidebar_variants) applySidebarVariant(data.dark_sidebar_variants);
            else applySidebarVariant(themeState.dark_sidebar_variants);

            if (data.accent_color) applyAccentColor(data.accent_color);
            else applyAccentColor(themeState.accent_color);

            markSaved();
        } catch (e) {
            console.warn("Theme settings fetch fallback:", e);
            applyNavbarColor(themeState.nav_color);
            applySidebarColor(themeState.sidebar_color);
            applySidebarVariant(themeState.dark_sidebar_variants);
            applyAccentColor(themeState.accent_color);
            markSaved();
        }
    })();
});
</script>
@endsection
