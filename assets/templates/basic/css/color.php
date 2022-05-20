<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}
?>



.cmn-btn-active:focus, .cmn-btn-active:hover, ::-webkit-scrollbar-button, ::-webkit-scrollbar-thumb, .cmn-btn, .cmn-btn::before, .cmn-btn::after, ::selection, .calculate-section .cal-area .cal-form .nice-select, .title-border::after, .scrollToTop, #overlayer .loader .loader-inner, .faq-wrapper .faq-item.open .faq-title, .call-to-action-form .submit-btn, .order-section .order-table thead tr, .pricing-tab-menu .nav-item .nav-link.active, .pricing-section .pricing-item .pricing-inner:hover, .pricing-section .pricing-item .pricing-inner:hover .pricing-icon i, .blog-thumb .overlay-date, .client-slider .swiper-pagination-bullet, .client-slider .swiper-slide-active .client-item, .footer-social li a::before, .register-section .register-form-area .register-form .register-icon i, .register-section .register-form-area::before, .register-section .register-form-area .register-form .submit-btn, .pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .dashboard-section .dash-user-area .dash-left-user-area .user-details .title, .title-border-left::after, .modal-header, .modal button[type="submit"], .input-group-text, .profile-edit label, .profile-form .submit-btn, .register-section .register-form-area .register-form .nice-select, .bg-theme, .badge-primary::before, .card-deposit .card-header{
    background-color: <?=$color?>;
}

.header-bottom-area .navbar-collapse .main-menu li a:hover, .cmn-btn:focus, .cmn-btn:hover, .about-section .about-content .about-item-area .about-item .about-details .title, .service-icon i, .custom-btn, .blog-item:hover .blog-content .title, .choose-section .choose-item-area .choose-item .choose-icon i, .footer-social li a:hover, .footer-social li a.active, .breadcrumb li, .contact-info-item i, .dashboard-section .dash-item .dash-content .sub-title span, .section-title span, .account-header .sub-title a, .register-section .register-form-area .register-form .forgot-password a, .work-section .work-content .work-item-area .work-item .work-icon i, .badge-primary, .text-primary{
    color: <?=$color?> !important;
}

.title-border::before, #overlayer .loader, .pricing-tab-menu .nav-item .nav-link.active, .pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .dashboard-section .dash-user-area .dash-left-user-area .user-icon, .title-border-left::before, .modal .form-control, .input-group-text, .work-section .work-content .work-item-area .work-item .work-icon, .badge-primary {
    border-color: <?=$color?>;
}

.pagination .page-item.disabled span {
    background-color: <?=$color?>99;
    border-color: <?=$color?>60;
}

.breadcrumb-item.active {
    color: #fff !important;
}

.badge-primary{
    background-color: <?=$color?>33;
}


.btn-primary, bg-primary, .custom-file-label::after{
    background-color: <?=$color?> !important;
}

.section-header .title-border-left::after {
    background-color: <?=$color?> !important;
}
.section-header .title-border-left::before {
    border-color: <?=$color?> !important;
}