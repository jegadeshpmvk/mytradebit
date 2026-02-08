<?php
if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSubscribed()) { ?>

<style>
/* ===== Overlay ===== */
.subscription_alert{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(6px);
    z-index:999;
}

/* ===== Popup Wrapper ===== */
.subscription_popup{
    position:fixed;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:1000;
}

/* ===== Container ===== */
.subscription_popup_container{
    width:420px;
    max-width:94%;
    background:linear-gradient(135deg,#ffffff,#f5efff);
    border-radius:22px;
    padding:28px;
    box-shadow:0 30px 70px rgba(122,76,255,0.35);
    animation:popupIn .4s ease;
    position:relative;
}

/* ===== Headline ===== */
.headline{
    font-size:26px;
    text-align:center;
    font-weight:800;
    margin-bottom:20px;
}
.headline span{
    color:#7a4cff;
}
.headline .fa-close{
    position:absolute;
    right:18px;
    top:18px;
    cursor:pointer;
    opacity:.6;
}

/* ===== Card ===== */
.popup_card{
    text-align:center;
}

/* ===== Badge ===== */
.popup_badge{
    display:inline-block;
    background:linear-gradient(90deg,#ff5f6d,#ffc371);
    color:#fff;
    padding:6px 14px;
    font-size:12px;
    border-radius:20px;
    font-weight:600;
    margin-bottom:12px;
}

/* ===== Logo ===== */
.popup_logo_circle{
    width:70px;
    height:70px;
    border-radius:50%;
    background:linear-gradient(135deg,#7a4cff,#9f7cff);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-weight:800;
    font-size:20px;
    margin:12px auto;
}

/* ===== Plan ===== */
.plan_name{
    font-size:20px;
    font-weight:700;
    margin-top:8px;
}

.plan_price{
    font-size:40px;
    font-weight:900;
    color:#222;
    margin-top:6px;
}
.plan_price span{
    font-size:16px;
}

.plan_validity{
    margin-top:6px;
    font-size:14px;
    color:#555;
}

/* ===== Buttons ===== */
.buy_btn{
    width:100%;
    border:none;
    padding:14px;
    border-radius:14px;
    margin-top:16px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.buy_btn:first-of-type{
    background:linear-gradient(135deg,#7a4cff,#9f7cff);
    color:#fff;
    box-shadow:0 12px 28px rgba(122,76,255,.45);
}

.buy_btn:hover{
    transform:translateY(-2px);
}

/* ===== Offer Text ===== */
.offer_text{
    margin-top:14px;
    font-size:13px;
    color:#e63946;
    font-weight:600;
}

/* ===== Features ===== */
.features_top{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-top:18px;
    font-size:14px;
    color:#333;
}

/* ===== Master Tool Button ===== */
.popup_card .buy_btn:last-of-type{
    background:#f1edff;
    color:#7a4cff;
    box-shadow:none;
}

/* ===== Unlock Grid ===== */
.popup_unlock_grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
    margin-top:16px;
    font-size:13px;
    color:#444;
}

/* ===== Animation ===== */
@keyframes popupIn{
    from{opacity:0;transform:scale(.9)}
    to{opacity:1;transform:scale(1)}
}
</style>

<div class="subscription_alert"></div>

<div class="subscription_popup">
    <div class="subscription_popup_container">
        <h1 class="headline">
            Profits at your <span>fingertip</span>
            <a class="fa fa-close"></a>
        </h1>

        <div class="popup_card">
            <div class="popup_badge">🔥 LIMITED OFFER</div>

            <div class="popup_logo">
                <div class="popup_logo_circle">MTB</div>
            </div>

            <h2 class="plan_name">MY TRADE BIT</h2>
            <div class="plan_price">₹799<span>/-</span></div>
            <div class="plan_validity">Validity = <b>1 Year</b></div>

            <button class="buy_btn">Buy Now</button>

            <p class="offer_text">⏳ Offer expiring soon – Price goes to ₹2999</p>

            <div class="features_top">
                <div>🚀 Instant Access</div>
                <div>📊 Trading Dashboard</div>
                <div>📈 All Strategies</div>
                <div>🛡 Risk Managed Setups</div>
            </div>

            <button class="buy_btn">Mastertool Features</button>

            <div class="popup_unlock_grid">
                <span>✔ Global Sentiments</span>
                <span>✔ Pre Market</span>
                <span>✔ Live Market</span>
                <span>✔ Sector Heatmap</span>
                <span>✔ Options & Futures</span>
                <span>✔ FII / DII</span>
                <span>✔ Momentum Stocks</span>
                <span>✔ OI Analysis</span>
                <span>✔ Intraday</span>
                <span>✔ Positional</span>
            </div>

            <!--p class="offer_text" style="color:#555;font-weight:500">
                Payment Gateway in progress<br><br>
                WhatsApp <b>9876543210</b> to get access<br><br>
                Join <b>100+ traders</b> using My Trade Bit
            </p-->
        </div>
    </div>
</div>

<?php } ?>
