<!doctype html>
<html lang="en" dir="">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="#0f172a" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{Session::get('nama_aplikasi')}}</title>
    @include('layouts.css')
    @stack('css')
    <style type="text/css">
        /* ============================================
           MODERN SIDEBAR NAVIGATION
           ============================================ */
        :root {
            --sidebar-width: 270px;
            --sidebar-collapsed: 0px;
            --topbar-height: 64px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: rgba(99, 102, 241, 0.15);
            --sidebar-active-border: #6366f1;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #e2e8f0;
            --sidebar-icon: #64748b;
            --sidebar-icon-active: #6366f1;
            --sidebar-divider: rgba(148, 163, 184, 0.08);
            --transition-speed: 0.25s;
        }

        body.color-light.fixed-top-navbar {
            padding-top: 0 !important;
        }

        /* Hide original horizontal menu system */
        .iq-top-navbar .iq-menu-horizontal,
        .iq-top-navbar .iq-navbar-custom > .d-flex > .iq-navbar-logo {
            display: none !important;
        }

        /* ---- Sidebar ---- */
        .modern-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-speed) cubic-bezier(.4,0,.2,1);
            box-shadow: 4px 0 24px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        .modern-sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        /* Sidebar Header / Logo */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--sidebar-divider);
            min-height: 64px;
        }

        .sidebar-header .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-header .sidebar-logo img {
            height: 36px;
            width: auto;
        }

        .sidebar-header .sidebar-logo span {
            font-size: 16px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.3px;
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: var(--sidebar-text);
            font-size: 22px;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background 0.15s;
        }

        .sidebar-close-btn:hover {
            background: var(--sidebar-hover);
        }

        /* Sidebar Scroll Area */
        .sidebar-nav-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0;
        }

        .sidebar-nav-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.15);
            border-radius: 10px;
        }

        .sidebar-nav-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.3);
        }

        /* Menu Section Label */
        .sidebar-section-label {
            display: block;
            padding: 20px 24px 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #475569;
        }

        /* Menu Items */
        .sidebar-nav {
            list-style: none;
            margin: 0;
            padding: 0 12px;
        }

        .sidebar-nav li {
            margin-bottom: 2px;
        }

        .sidebar-nav > li > a,
        .sidebar-nav > li > .nav-link-toggle {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            position: relative;
        }

        .sidebar-nav > li > a:hover,
        .sidebar-nav > li > .nav-link-toggle:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .sidebar-nav > li > a:hover .nav-icon,
        .sidebar-nav > li > .nav-link-toggle:hover .nav-icon {
            color: var(--sidebar-icon-active);
        }

        .sidebar-nav > li.active > a,
        .sidebar-nav > li.active > .nav-link-toggle {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
        }

        .sidebar-nav > li.active > a .nav-icon,
        .sidebar-nav > li.active > .nav-link-toggle .nav-icon {
            color: var(--sidebar-icon-active);
        }

        .sidebar-nav > li.active > a::before,
        .sidebar-nav > li.active > .nav-link-toggle::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: var(--sidebar-active-border);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
            color: var(--sidebar-icon);
            flex-shrink: 0;
            transition: color 0.15s;
        }

        .nav-label {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-arrow {
            font-size: 12px;
            transition: transform var(--transition-speed) ease;
            color: #475569;
            margin-left: auto;
        }

        .nav-link-toggle[aria-expanded="true"] .nav-arrow {
            transform: rotate(90deg);
        }

        /* Submenu */
        .sidebar-submenu {
            list-style: none;
            margin: 0;
            padding: 4px 0 4px 20px;
            overflow: hidden;
        }

        .sidebar-submenu li {
            margin-bottom: 1px;
        }

        .sidebar-submenu li > a,
        .sidebar-submenu li > .nav-link-toggle {
            display: flex;
            align-items: center;
            padding: 8px 14px 8px 24px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13px;
            font-weight: 400;
            border-radius: 8px;
            transition: all 0.15s ease;
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .sidebar-submenu li > a::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334155;
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.15s;
        }

        .sidebar-submenu li > a:hover {
            color: var(--sidebar-text-active);
            background: rgba(148, 163, 184, 0.06);
        }

        .sidebar-submenu li > a:hover::before {
            background: var(--sidebar-icon-active);
        }

        .sidebar-submenu li.active > a {
            color: var(--sidebar-icon-active);
            background: rgba(99, 102, 241, 0.08);
            font-weight: 500;
        }

        .sidebar-submenu li.active > a::before {
            background: var(--sidebar-icon-active);
            box-shadow: 0 0 6px rgba(99, 102, 241, 0.5);
        }

        /* Nested submenu (level 3) */
        .sidebar-submenu .sidebar-submenu {
            padding-left: 12px;
        }

        .sidebar-submenu .sidebar-submenu li > a {
            padding-left: 20px;
            font-size: 12.5px;
        }

        .sidebar-submenu .sidebar-submenu li > a::before {
            width: 5px;
            height: 5px;
            left: 6px;
        }

        /* Badge / Count */
        .nav-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 7px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 10px;
            background: #6366f1;
            color: #fff;
            margin-left: 8px;
            min-width: 18px;
        }

        /* Sidebar Footer (User) */
        .sidebar-footer {
            border-top: 1px solid var(--sidebar-divider);
            padding: 12px 16px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.15s;
            position: relative;
        }

        .sidebar-user:hover {
            background: var(--sidebar-hover);
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        /* User dropdown */
        .sidebar-user-dropdown {
            display: none;
            position: absolute;
            bottom: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #1e293b;
            border-radius: 12px;
            box-shadow: 0 -8px 24px rgba(0,0,0,0.3);
            padding: 8px;
            z-index: 10;
        }

        .sidebar-user-dropdown.show {
            display: block;
        }

        .sidebar-user-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13px;
            border-radius: 8px;
            transition: all 0.15s;
        }

        .sidebar-user-dropdown a:hover {
            background: rgba(148, 163, 184, 0.1);
            color: var(--sidebar-text-active);
        }

        .sidebar-user-dropdown a.text-danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        .sidebar-user-dropdown .dropdown-divider {
            border-top: 1px solid var(--sidebar-divider);
            margin: 4px 0;
        }

        /* ---- Top Bar (simplified) ---- */
        .iq-top-navbar {
            position: fixed !important;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            z-index: 1030;
            display: flex;
            align-items: center;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: left var(--transition-speed) cubic-bezier(.4,0,.2,1);
            padding: 0 24px;
        }

        body.sidebar-collapsed .iq-top-navbar {
            left: 0;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-toggle-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: #334155;
            cursor: pointer;
            padding: 6px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
        }

        .topbar-toggle-btn:hover {
            background: #f1f5f9;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-icon-btn {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .topbar-icon-btn:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        /* ---- Content Area ---- */
        .content-page {
            margin-left: var(--sidebar-width) !important;
            padding-top: calc(var(--topbar-height) + 20px) !important;
            transition: margin-left var(--transition-speed) cubic-bezier(.4,0,.2,1);
            min-height: 100vh;
        }

        body.sidebar-collapsed .content-page {
            margin-left: 0 !important;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* ============================================
           MOBILE BOTTOM NAVIGATION
           ============================================ */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: calc(56px + env(safe-area-inset-bottom, 0px));
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            z-index: 1050;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        .mobile-bottom-nav .bottom-nav-items {
            display: flex;
            align-items: center;
            justify-content: space-around;
            height: 56px;
            padding: 0 4px;
        }

        .mobile-bottom-nav .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #64748b;
            font-size: 10px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 8px;
            transition: all 0.15s;
            -webkit-tap-highlight-color: transparent;
            min-width: 56px;
            gap: 2px;
            border: none;
            background: none;
            cursor: pointer;
        }

        .mobile-bottom-nav .bottom-nav-item i {
            font-size: 20px;
            line-height: 1;
        }

        .mobile-bottom-nav .bottom-nav-item.active {
            color: var(--sidebar-active-border);
        }

        .mobile-bottom-nav .bottom-nav-item:active {
            background: #f1f5f9;
            transform: scale(0.95);
        }

        body.dark .mobile-bottom-nav {
            background: #0f172a;
            border-top-color: #1e293b;
        }

        body.dark .mobile-bottom-nav .bottom-nav-item {
            color: #64748b;
        }

        body.dark .mobile-bottom-nav .bottom-nav-item.active {
            color: var(--sidebar-active-border);
        }

        body.dark .mobile-bottom-nav .bottom-nav-item:active {
            background: #1e293b;
        }

        /* ============================================
           RESPONSIVE BREAKPOINTS - ALL DEVICES
           ============================================ */

        /* === Desktop XL: iMac 27", 4K monitors (1920px+) === */
        @media (min-width: 1920px) {
            :root {
                --sidebar-width: 290px;
            }

            .content-page .container {
                max-width: 1600px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 12px 16px;
                font-size: 14px;
            }

            .sidebar-submenu li > a {
                padding: 9px 14px 9px 26px;
                font-size: 13.5px;
            }
        }

        /* === Desktop: MacBook Pro 16", iMac 24" (1440-1919px) === */
        @media (min-width: 1440px) and (max-width: 1919px) {
            :root {
                --sidebar-width: 270px;
            }

            .content-page .container {
                max-width: 1400px;
            }
        }

        /* === Laptop: MacBook Air 13", common laptops (1200-1439px) === */
        @media (min-width: 1200px) and (max-width: 1439px) {
            :root {
                --sidebar-width: 256px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 9px 12px;
                font-size: 13px;
            }

            .sidebar-submenu li > a {
                padding: 7px 12px 7px 22px;
                font-size: 12.5px;
            }

            .sidebar-section-label {
                padding: 16px 20px 6px;
                font-size: 9.5px;
            }

            .nav-icon {
                font-size: 15px;
                margin-right: 10px;
            }
        }

        /* === Tablet / iPad Pro Landscape & below (<=1199px): sidebar becomes drawer === */
        @media (max-width: 1199px) {
            :root {
                --sidebar-width: 280px;
            }

            .modern-sidebar {
                transform: translateX(calc(-1 * var(--sidebar-width)));
            }

            .modern-sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
            }

            .iq-top-navbar {
                left: 0 !important;
                padding: 0 16px;
            }

            .content-page {
                margin-left: 0 !important;
            }
        }

        /* === iPad Pro 12.9" Portrait (1024px) === */
        @media (min-width: 1024px) and (max-width: 1199px) {
            .content-page .container {
                max-width: 960px;
                padding: 0 20px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 11px 14px;
                font-size: 14px;
            }

            .sidebar-submenu li > a {
                padding: 9px 14px 9px 24px;
                font-size: 13px;
            }
        }

        /* === iPad Air / iPad 10th Landscape, iPad Pro Portrait (820-1023px) === */
        @media (min-width: 820px) and (max-width: 1023px) {
            .content-page .container {
                max-width: 100%;
                padding: 0 20px;
            }

            .topbar-toggle-btn {
                font-size: 24px;
                padding: 8px;
            }
        }

        /* === iPad Mini / iPad Portrait (768-819px) === */
        @media (min-width: 768px) and (max-width: 819px) {
            :root {
                --topbar-height: 58px;
            }

            .content-page .container {
                max-width: 100%;
                padding: 0 16px;
            }
        }

        /* === Tablet Portrait & Large Phones (600-767px) === */
        @media (max-width: 767px) {
            :root {
                --topbar-height: 56px;
                --sidebar-width: 300px;
            }

            .mobile-bottom-nav {
                display: block;
            }

            .content-page {
                padding-bottom: calc(56px + env(safe-area-inset-bottom, 0px) + 16px) !important;
            }

            .content-page .container {
                max-width: 100%;
                padding: 0 12px;
            }

            .iq-top-navbar {
                padding: 0 12px;
                height: var(--topbar-height);
            }

            /* Touch-friendly menu items */
            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 12px 14px;
                font-size: 14px;
                min-height: 44px;
            }

            .sidebar-submenu li > a {
                padding: 10px 14px 10px 24px;
                font-size: 13.5px;
                min-height: 40px;
            }

            .sidebar-section-label {
                padding: 18px 24px 8px;
                font-size: 10.5px;
            }

            .sidebar-user-dropdown {
                left: 8px;
                right: 8px;
            }

            /* Better table scrolling on tablets */
            .table-responsive,
            .card-body {
                -webkit-overflow-scrolling: touch;
            }
        }

        /* === Samsung Galaxy Fold unfolded (717px), Galaxy Tab (600px) === */
        @media (min-width: 600px) and (max-width: 767px) {
            :root {
                --sidebar-width: 320px;
            }
        }

        /* === Phone Landscape & Small Tablets (480-599px) === */
        @media (min-width: 480px) and (max-width: 599px) {
            :root {
                --sidebar-width: 300px;
            }

            .sidebar-header .sidebar-logo span {
                font-size: 15px;
            }
        }

        /* === iPhone Pro Max, Samsung Galaxy S Ultra (431-479px) === */
        @media (min-width: 431px) and (max-width: 479px) {
            :root {
                --sidebar-width: 300px;
            }
        }

        /* === Standard Phones: iPhone 15/14/13/12 Pro Max (430px) === */
        /* === iPhone 15/14/13/12 (390px), Samsung Galaxy S (360-412px) === */
        @media (max-width: 430px) {
            :root {
                --sidebar-width: 100%;
                --topbar-height: 52px;
            }

            .modern-sidebar {
                width: 100%;
                border-radius: 0;
            }

            .sidebar-header {
                padding: 12px 16px;
                min-height: 56px;
            }

            .sidebar-header .sidebar-logo img {
                height: 32px;
            }

            .sidebar-header .sidebar-logo span {
                font-size: 15px;
            }

            .sidebar-close-btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }

            .sidebar-nav {
                padding: 0 10px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 12px 12px;
                font-size: 14px;
                min-height: 48px;
                border-radius: 12px;
            }

            .nav-icon {
                width: 22px;
                height: 22px;
                font-size: 17px;
                margin-right: 12px;
            }

            .sidebar-submenu li > a {
                padding: 11px 12px 11px 24px;
                font-size: 13.5px;
                min-height: 44px;
                border-radius: 10px;
            }

            .sidebar-submenu li > a::before {
                width: 7px;
                height: 7px;
            }

            .sidebar-section-label {
                padding: 16px 20px 6px;
                font-size: 10px;
            }

            .sidebar-footer {
                padding: 10px 12px;
            }

            .sidebar-user {
                padding: 10px;
            }

            .sidebar-user-avatar {
                width: 40px;
                height: 40px;
            }

            .sidebar-user-name {
                font-size: 14px;
            }

            .sidebar-user-role {
                font-size: 12px;
            }

            .sidebar-user-dropdown a {
                padding: 11px 14px;
                font-size: 14px;
                min-height: 44px;
            }

            .iq-top-navbar {
                padding: 0 10px;
            }

            .topbar-toggle-btn {
                font-size: 24px;
                width: 44px;
                height: 44px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar-icon-btn {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }

            .content-page .container {
                padding: 0 10px;
            }

            .mobile-bottom-nav .bottom-nav-item {
                font-size: 9.5px;
                min-width: 52px;
                padding: 4px 6px;
            }

            .mobile-bottom-nav .bottom-nav-item i {
                font-size: 19px;
            }
        }

        /* === iPhone SE, Samsung Galaxy S Mini (375px and below) === */
        @media (max-width: 375px) {
            .sidebar-header .sidebar-logo span {
                font-size: 14px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 11px 10px;
                font-size: 13.5px;
            }

            .nav-icon {
                margin-right: 10px;
            }

            .sidebar-submenu li > a {
                padding: 10px 10px 10px 22px;
                font-size: 13px;
            }

            .mobile-bottom-nav .bottom-nav-item {
                font-size: 9px;
                min-width: 48px;
                padding: 4px 4px;
            }

            .mobile-bottom-nav .bottom-nav-item i {
                font-size: 18px;
            }
        }

        /* === Samsung Galaxy Fold folded (280px) === */
        @media (max-width: 320px) {
            .sidebar-header .sidebar-logo img {
                height: 28px;
            }

            .sidebar-header .sidebar-logo span {
                font-size: 13px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 10px 8px;
                font-size: 13px;
            }

            .nav-icon {
                width: 18px;
                height: 18px;
                font-size: 14px;
                margin-right: 8px;
            }

            .sidebar-submenu li > a {
                padding: 9px 8px 9px 20px;
                font-size: 12.5px;
            }

            .sidebar-submenu li > a::before {
                width: 5px;
                height: 5px;
                left: 6px;
            }

            .sidebar-user-avatar {
                width: 32px;
                height: 32px;
            }

            .sidebar-user-name {
                font-size: 12px;
            }

            .mobile-bottom-nav .bottom-nav-item {
                font-size: 8px;
                min-width: 44px;
            }

            .mobile-bottom-nav .bottom-nav-item i {
                font-size: 16px;
            }
        }

        /* ============================================
           iOS / ANDROID SAFE AREA & TOUCH SUPPORT
           ============================================ */

        /* iOS safe areas (notch, Dynamic Island, home indicator) */
        @supports (padding: env(safe-area-inset-top)) {
            .iq-top-navbar {
                padding-top: env(safe-area-inset-top, 0px);
                height: calc(var(--topbar-height) + env(safe-area-inset-top, 0px));
            }

            .modern-sidebar {
                padding-top: env(safe-area-inset-top, 0px);
            }

            .content-page {
                padding-top: calc(var(--topbar-height) + env(safe-area-inset-top, 0px) + 20px) !important;
            }

            .mobile-bottom-nav {
                height: calc(56px + env(safe-area-inset-bottom, 0px));
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }

            .sidebar-footer {
                padding-bottom: calc(12px + env(safe-area-inset-bottom, 0px));
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            /* Larger touch targets - minimum 44px per Apple HIG */
            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                min-height: 44px;
            }

            .sidebar-submenu li > a {
                min-height: 40px;
            }

            .topbar-toggle-btn,
            .topbar-icon-btn {
                min-width: 44px;
                min-height: 44px;
            }

            .sidebar-user-dropdown a {
                min-height: 44px;
            }

            /* Disable hover effects on touch */
            .sidebar-nav > li > a:hover,
            .sidebar-nav > li > .nav-link-toggle:hover {
                background: none;
                color: var(--sidebar-text);
            }

            .sidebar-nav > li > a:hover .nav-icon,
            .sidebar-nav > li > .nav-link-toggle:hover .nav-icon {
                color: var(--sidebar-icon);
            }

            .sidebar-nav > li.active > a:hover,
            .sidebar-nav > li.active > .nav-link-toggle:hover {
                background: var(--sidebar-active);
                color: var(--sidebar-text-active);
            }

            .sidebar-nav > li.active > a:hover .nav-icon,
            .sidebar-nav > li.active > .nav-link-toggle:hover .nav-icon {
                color: var(--sidebar-icon-active);
            }

            /* Active (tap) state for touch feedback */
            .sidebar-nav > li > a:active,
            .sidebar-nav > li > .nav-link-toggle:active {
                background: var(--sidebar-hover);
                color: var(--sidebar-text-active);
                transform: scale(0.98);
            }

            .sidebar-submenu li > a:active {
                background: rgba(148, 163, 184, 0.1);
                transform: scale(0.98);
            }

            /* Smooth momentum scrolling */
            .sidebar-nav-scroll {
                -webkit-overflow-scrolling: touch;
            }

            /* Remove 300ms tap delay */
            * {
                touch-action: manipulation;
            }

            /* Prevent text selection while scrolling sidebar */
            .modern-sidebar {
                -webkit-user-select: none;
                user-select: none;
            }

            .sidebar-submenu li > a,
            .sidebar-nav > li > a {
                -webkit-user-select: text;
                user-select: text;
            }
        }

        /* Landscape orientation for phones */
        @media (max-height: 500px) and (orientation: landscape) {
            :root {
                --topbar-height: 48px;
            }

            .mobile-bottom-nav {
                display: none !important;
            }

            .sidebar-header {
                min-height: 48px;
                padding: 8px 16px;
            }

            .sidebar-header .sidebar-logo img {
                height: 28px;
            }

            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle {
                padding: 7px 12px;
                min-height: 36px;
                font-size: 12.5px;
            }

            .sidebar-submenu li > a {
                padding: 6px 12px 6px 22px;
                min-height: 32px;
                font-size: 12px;
            }

            .sidebar-section-label {
                padding: 10px 20px 4px;
                font-size: 9px;
            }

            .sidebar-footer {
                padding: 6px 12px;
            }

            .sidebar-user {
                padding: 6px;
            }

            .sidebar-user-avatar {
                width: 28px;
                height: 28px;
            }

            .content-page {
                padding-bottom: 16px !important;
            }
        }

        /* High DPI / Retina displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .sidebar-submenu li > a::before {
                border: 0.5px solid transparent;
            }

            .sidebar-nav > li.active > a::before,
            .sidebar-nav > li.active > .nav-link-toggle::before {
                border: 0.5px solid transparent;
            }
        }

        /* Prefer reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .modern-sidebar,
            .iq-top-navbar,
            .content-page,
            .sidebar-nav > li > a,
            .sidebar-nav > li > .nav-link-toggle,
            .sidebar-submenu li > a,
            .nav-arrow,
            .sidebar-overlay {
                transition: none !important;
            }
        }

        /* ---- Misc overrides ---- */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.42rem;
            float: right !important;
        }

        #container_spinner {
            width: 100%;
            height: auto;
            text-align: center;
            position: absolute;
            top: 50%;
        }

        .lds-spinner {
            color: official;
            display: inline-block;
            position: relative;
            margin: auto 0;
            width: 80px;
            height: 80px;
        }

        .lds-spinner div {
            transform-origin: 40px 40px;
            animation: lds-spinner 1.2s linear infinite;
        }

        .lds-spinner div:after {
            content: " ";
            display: block;
            position: absolute;
            top: 3px;
            left: 37px;
            width: 6px;
            height: 18px;
            border-radius: 20%;
            background: #8c99e0;
        }

        .lds-spinner div:nth-child(1) { transform: rotate(0deg); animation-delay: -1.1s; }
        .lds-spinner div:nth-child(2) { transform: rotate(30deg); animation-delay: -1s; }
        .lds-spinner div:nth-child(3) { transform: rotate(60deg); animation-delay: -0.9s; }
        .lds-spinner div:nth-child(4) { transform: rotate(90deg); animation-delay: -0.8s; }
        .lds-spinner div:nth-child(5) { transform: rotate(120deg); animation-delay: -0.7s; }
        .lds-spinner div:nth-child(6) { transform: rotate(150deg); animation-delay: -0.6s; }
        .lds-spinner div:nth-child(7) { transform: rotate(180deg); animation-delay: -0.5s; }
        .lds-spinner div:nth-child(8) { transform: rotate(210deg); animation-delay: -0.4s; }
        .lds-spinner div:nth-child(9) { transform: rotate(240deg); animation-delay: -0.3s; }
        .lds-spinner div:nth-child(10) { transform: rotate(270deg); animation-delay: -0.2s; }
        .lds-spinner div:nth-child(11) { transform: rotate(300deg); animation-delay: -0.1s; }
        .lds-spinner div:nth-child(12) { transform: rotate(330deg); animation-delay: 0s; }

        @keyframes lds-spinner {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Dark mode support */
        body.dark .modern-sidebar {
            background: #020617;
        }

        body.dark .iq-top-navbar {
            background: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        body.dark .topbar-toggle-btn {
            color: #e2e8f0;
        }

        body.dark .topbar-toggle-btn:hover {
            background: #1e293b;
        }

        body.dark .topbar-title {
            color: #e2e8f0;
        }

        body.dark .topbar-icon-btn {
            color: #94a3b8;
        }

        body.dark .topbar-icon-btn:hover {
            background: #1e293b;
            color: #e2e8f0;
        }
    </style>
</head>

<body class="color-light fixed-top-navbar">
    <div id="loading">
        <div id="loading-center"></div>
    </div>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Modern Sidebar -->
    <aside class="modern-sidebar" id="modernSidebar">
        <div class="sidebar-header">
            <a href="{{URL::to('/')}}" class="sidebar-logo">
                <img src="{{URL::to('assets/images/logo.png')}}" alt="logo">
                <span>{{Session::get('nama_aplikasi') ?: 'ESDM'}}</span>
            </a>
            <button class="sidebar-close-btn" id="sidebarCloseBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sidebar-nav-scroll" id="sidebarScroll">
            @if(auth()->user()->ganti_pass == null)
                @if(Session::get('level') == "SA" || Session::get('level') == "A" || Session::get('level') == "PI")
                    @include('menu.admin_sidebar')
                @elseif(Session::get('level')=="P")
                    @include('menu.pegawai_sidebar')
                @elseif(Session::get('level')=="B")
                    @include('menu.baak_sidebar')
                @endif
            @endif
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user" id="sidebarUserToggle">
                <img src="{{URL::to('assets/images/user/1.jpg')}}" alt="avatar" class="sidebar-user-avatar">
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{Session::get('nama_pengguna')}}</span>
                    <span class="sidebar-user-role">{{Session::get('userlevel')}}</span>
                </div>
                <i class="fas fa-ellipsis-v" style="color: #64748b; font-size: 14px;"></i>

                <div class="sidebar-user-dropdown" id="sidebarUserDropdown">
                    @if(Session::get('usertype'))
                        @if(count(Session::get('user_unit'))>0 && Session::get('jns_usertype') == "Dosen")
                            <a href="{{URL::to('loginaspimpinan')}}/{{Session::get('id_pengguna')}}">
                                <i class="fas fa-user-graduate"></i> Login as Pimpinan
                            </a>
                        @endif
                        @if(Session::get('login_pimpinan')!=null or Session::get('login_satuan')!=null)
                            <a href="{{URL::to('loginas')}}/{{Session::get('id_pengguna')}}">
                                <i class="fas fa-user-tie"></i> Login as Dosen
                            </a>
                        @endif
                    @endif
                    <a href="{{route('ubahpassword')}}">
                        <i class="fas fa-key"></i> Ubah Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('logout')}}" class="text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav" id="mobileBottomNav">
        <div class="bottom-nav-items">
            @if(Session::get('level') == "SA" || Session::get('level') == "A" || Session::get('level') == "PI")
                <a href="{{URL::to('/home')}}" class="bottom-nav-item {{ request()->is('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{route('data-pegawai.master-pegawai.index')}}" class="bottom-nav-item {{ request()->is('data-pegawai/master-pegawai*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Pegawai</span>
                </a>
                <a href="{{route('data-pegawai.data-presensi.upload-presensi.index')}}" class="bottom-nav-item {{ request()->is('data-pegawai/data-presensi*') ? 'active' : '' }}">
                    <i class="fas fa-fingerprint"></i>
                    <span>Presensi</span>
                </a>
                <a href="{{route('laporan.presensi-kehadiran.index')}}" class="bottom-nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            @elseif(Session::get('level')=="P")
                <a href="{{URL::to('/beranda')}}" class="bottom-nav-item {{ request()->is('beranda') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{URL::to('/pegawai/detil')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}" class="bottom-nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i>
                    <span>Profil</span>
                </a>
                <a href="{{URL::to('skp-pegawai/skp/')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}" class="bottom-nav-item {{ request()->is('skp-pegawai*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>SKP</span>
                </a>
            @endif
            <button class="bottom-nav-item" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
                <span>Menu</span>
            </button>
        </div>
    </nav>

    <div class="wrapper">
        <!-- Simplified Top Bar -->
        <div class="iq-top-navbar">
            <div class="topbar-left">
                <button class="topbar-toggle-btn" id="sidebarToggleBtn">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
            <div class="topbar-right">
                <div class="change-mode">
                    <div class="custom-control custom-switch custom-switch-icon custom-control-indivne">
                        <div class="custom-switch-inner">
                            <p class="mb-0"> </p>
                            <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                            <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                <span class="switch-icon-left"><i class="a-left ri-moon-clear-line"></i></span>
                                <span class="switch-icon-right"><i class="a-right ri-sun-line"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
                <button class="topbar-icon-btn" id="btnFullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>
        </div>

        <div class="content-page">
            <div class="container">
                @yield('content')
            </div>

            <div id="container_spinner">
                <div class="lds-spinner">
                    <div></div><div></div><div></div><div></div>
                    <div></div><div></div><div></div><div></div>
                    <div></div><div></div><div></div><div></div>
                </div>
            </div>
        </div>
    </div>
    <div id="balik"></div>
    @include('layouts.js')
    <script>
        let body = $("body");
        $('#container_spinner').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

        // ============================================
        // SIDEBAR NAVIGATION LOGIC
        // ============================================
        (function() {
            var sidebar = document.getElementById('modernSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            var toggleBtn = document.getElementById('sidebarToggleBtn');
            var closeBtn = document.getElementById('sidebarCloseBtn');
            var mobileMenuBtn = document.getElementById('mobileMenuBtn');
            var userToggle = document.getElementById('sidebarUserToggle');
            var userDropdown = document.getElementById('sidebarUserDropdown');
            var isMobile = window.innerWidth < 1200;

            function openSidebar() {
                if (isMobile) {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeSidebar() {
                if (isMobile) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            function toggleSidebar() {
                if (isMobile) {
                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                } else {
                    sidebar.classList.toggle('collapsed');
                    document.body.classList.toggle('sidebar-collapsed');
                    // Save preference
                    try {
                        localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
                    } catch(e) {}
                }
            }

            // Restore desktop sidebar state
            try {
                if (!isMobile && localStorage.getItem('sidebar-collapsed') === 'true') {
                    sidebar.classList.add('collapsed');
                    document.body.classList.add('sidebar-collapsed');
                }
            } catch(e) {}

            toggleBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            // Mobile bottom nav menu button
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openSidebar();
                });
            }

            // Submenu toggle
            document.querySelectorAll('.nav-link-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    var submenu = this.nextElementSibling;
                    var isExpanded = this.getAttribute('aria-expanded') === 'true';

                    // Close other sibling submenus at same level
                    var parent = this.closest('li').parentElement;
                    parent.querySelectorAll(':scope > li > .nav-link-toggle[aria-expanded="true"]').forEach(function(otherToggle) {
                        if (otherToggle !== toggle) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                            $(otherToggle.nextElementSibling).slideUp(200);
                        }
                    });

                    // Toggle current
                    this.setAttribute('aria-expanded', !isExpanded);
                    if (isExpanded) {
                        $(submenu).slideUp(200);
                    } else {
                        $(submenu).slideDown(200);
                    }
                });
            });

            // Close sidebar on link click (mobile only)
            if (isMobile) {
                document.querySelectorAll('.sidebar-submenu a[href], .sidebar-nav > li > a[href]').forEach(function(link) {
                    link.addEventListener('click', function() {
                        setTimeout(closeSidebar, 150);
                    });
                });
            }

            // User dropdown
            userToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!userToggle.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });

            // Handle resize
            var resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    var wasMobile = isMobile;
                    isMobile = window.innerWidth < 1200;
                    if (wasMobile && !isMobile) {
                        sidebar.classList.remove('open');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }, 100);
            });

            // Swipe to close sidebar (mobile)
            var touchStartX = 0;
            var touchCurrentX = 0;
            var swiping = false;

            sidebar.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
                swiping = true;
            }, { passive: true });

            sidebar.addEventListener('touchmove', function(e) {
                if (!swiping) return;
                touchCurrentX = e.touches[0].clientX;
            }, { passive: true });

            sidebar.addEventListener('touchend', function() {
                if (!swiping) return;
                swiping = false;
                var diff = touchStartX - touchCurrentX;
                if (diff > 60) {
                    closeSidebar();
                }
            }, { passive: true });

            // Auto-scroll active menu into view
            var activeItem = sidebar.querySelector('.sidebar-submenu li.active');
            if (activeItem) {
                setTimeout(function() {
                    activeItem.scrollIntoView({ block: 'center', behavior: 'smooth' });
                }, 300);
            }
        })();
    </script>
    @stack('js')
</body>

</html>
