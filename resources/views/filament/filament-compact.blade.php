<style>
    /* ==========================================================================
       Filament High-Density & Compact Theme for Salonkita LMS
       ========================================================================== */

    /* Custom thin scrollbar */
    .fi-sidebar-nav::-webkit-scrollbar,
    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }
    .fi-sidebar-nav::-webkit-scrollbar-track,
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    .fi-sidebar-nav::-webkit-scrollbar-thumb,
    ::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.4);
        border-radius: 9999px;
    }
    .fi-sidebar-nav::-webkit-scrollbar-thumb:hover,
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }

    /* Sidebar Navigation Compact Styles */
    .fi-sidebar-nav {
        padding: 0.5rem 0.5rem 1.5rem 0.5rem !important;
        gap: 0.25rem !important;
    }
    .fi-sidebar-group {
        margin-top: 0.5rem !important;
        padding-top: 0.25rem !important;
    }
    .fi-sidebar-group-label,
    .fi-sidebar-group-btn {
        padding: 0.25rem 0.65rem !important;
        font-size: 0.6875rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
    }
    .fi-sidebar-item {
        margin-bottom: 0.125rem !important;
    }
    .fi-sidebar-item-btn {
        padding: 0.35rem 0.65rem !important;
        min-height: 2.125rem !important;
        border-radius: 0.5rem !important;
        font-size: 0.8125rem !important;
        gap: 0.5rem !important;
        transition: all 0.15s ease-in-out;
    }
    .fi-sidebar-item-btn:hover {
        background-color: rgba(255, 77, 158, 0.08) !important;
    }
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn {
        background-color: rgba(255, 77, 158, 0.15) !important;
    }
    .fi-sidebar-item-icon {
        width: 1.15rem !important;
        height: 1.15rem !important;
        flex-shrink: 0 !important;
    }
    .fi-sidebar-item-label {
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .fi-sidebar-item-badge {
        font-size: 0.6875rem !important;
        padding: 0.1rem 0.4rem !important;
        border-radius: 9999px !important;
    }

    /* Page Layout & Spacing */
    .fi-main-ctn {
        padding-top: 1rem !important;
        padding-bottom: 2rem !important;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
    }
    .fi-page-header {
        margin-bottom: 1rem !important;
    }
    .fi-page-header-heading {
        font-size: 1.35rem !important;
        font-weight: 700 !important;
        letter-spacing: -0.01em !important;
    }
    .fi-page-header-subheading {
        font-size: 0.8125rem !important;
        margin-top: 0.15rem !important;
    }

    /* Compact Grid Gap for Widgets & Sections */
    .fi-page-content {
        gap: 1rem !important;
    }
    .fi-page-content > .grid {
        gap: 1rem !important;
    }

    /* Compact Stats Overview Widget */
    .fi-wi-stats-overview > .grid {
        gap: 0.75rem !important;
    }
    .fi-wi-stats-overview-stat {
        padding: 0.85rem 1rem !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05) !important;
    }
    .fi-wi-stats-overview-stat-label {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.025em !important;
        text-transform: uppercase !important;
    }
    .fi-wi-stats-overview-stat-value {
        font-size: 1.45rem !important;
        font-weight: 800 !important;
        line-height: 1.25 !important;
        margin-top: 0.25rem !important;
    }
    .fi-wi-stats-overview-stat-description {
        font-size: 0.75rem !important;
        margin-top: 0.35rem !important;
    }
    .fi-wi-stats-overview-stat-description svg {
        width: 0.875rem !important;
        height: 0.875rem !important;
    }

    /* Equal Height & Precision for Chart Widgets */
    .fi-wi-chart {
        height: 100% !important;
    }
    .fi-wi-chart .fi-section {
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05) !important;
    }
    .fi-wi-chart .fi-section-header {
        padding: 0.75rem 1rem !important;
    }
    .fi-wi-chart .fi-section-header-heading {
        font-size: 0.9375rem !important;
        font-weight: 700 !important;
    }
    .fi-wi-chart .fi-section-content-ctn {
        flex: 1 1 auto !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        padding: 0.75rem 1rem !important;
    }
    .fi-wi-chart .fi-section-content {
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }
    .fi-wi-chart canvas {
        width: 100% !important;
        max-height: 280px !important;
    }

    /* Compact Welcome / Account Widget */
    .fi-wi-account .fi-section-content {
        padding: 0.75rem 1rem !important;
    }

    /* Compact Resource Tables */
    .fi-ta-table th {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.025em !important;
        text-transform: uppercase !important;
    }
    .fi-ta-table td {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.8125rem !important;
    }
    .fi-ta-header-toolbar {
        padding: 0.75rem 1rem !important;
        gap: 0.5rem !important;
    }
    .fi-ta-actions {
        gap: 0.25rem !important;
    }

    /* Compact Form Inputs */
    .fi-fo-field-wrp-label {
        font-size: 0.8125rem !important;
        margin-bottom: 0.25rem !important;
    }
    .fi-input-wrp {
        font-size: 0.8125rem !important;
        border-radius: 0.5rem !important;
    }
</style>
