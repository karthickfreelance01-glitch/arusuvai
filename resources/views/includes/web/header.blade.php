<style>
    /* ===== BOOK NOW CTA ===== */
.book-now-btn{
    display:flex;
    align-items:center;
    gap:6px;
    padding:8px 16px;
    border-radius:30px;
    font-weight:600;
    font-size:14px;
    color:#fff !important;
    background:linear-gradient(134deg, #00adef, #00adef);
    box-shadow:0 6px 18px rgba(34,197,94,.35);
    transition:all .3s ease;
}

.book-now-btn i{
    font-size:16px;
}

/* Hover effect */
.book-now-btn:hover{
    transform:translateY(-2px) scale(1.05);
    box-shadow:0 10px 25px rgba(34,197,94,.5);
    text-decoration:none;
}

/* ===== HEADER ACTIONS ===== */
.header-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px;
}

/* Mobile only */
@media (max-width: 768px){

    .header-middle .row{
        align-items:center;
    }

    .book-now-btn{
        padding:6px 14px;
        font-size:13px;
        white-space:nowrap;
    }

    .mobile-menu-toggle{
        display:flex;
        align-items:center;
    }

    .mobile-menu-toggle .btn-toggle{
        width:36px;
        height:36px;
        display:flex;
        flex-direction:column;
        justify-content:center;
        gap:4px;
    }

    .mobile-menu-toggle span{
        display:block;
        height:2px;
        width:22px;
        background:#333;
    }
}


</style>
<header id="header" class="header-area style-01 layout-02">
        
        <div class="header-middle biolife-sticky-object ">
            <div class="container">
                <div class="row">
                     <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="{{url('/')}}" class="biolife-logo text-center"><img src="{{asset('admin/assets/images/logo/logo.jpeg')}}" alt="logo" width="120" height="34"></a>
                    </div>
                   

                    
                </div>
            </div>
        </div>
    </header>