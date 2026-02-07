<?php

if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSubscribed()) { ?>
    <div class="subscription_alert">

    </div>

    <div class="subscription_popup">
        <div class="subscription_popup_container">
            <h1 class="headline">Profits at your <span>fingertip</span> <a class="fa fa-close"></a></h1>
            <div class="popup_card">
                <div class="popup_badge">LIMITED OFFER</div>
                <div class="popup_logo">
                    <div class="popup_logo_circle">MTB</div>
                </div>
                <h2 class="plan_name">MY TRADE BIT</h2>
                <div class="plan_price">₹799<span>/-</span></div>
                <div class="old_price">Without Offer ₹2999</div>
                <div class="plan_validity">Validity = <b>1 Year</b></div>
                <button class="buy_btn">Buy Now</button>
                <p class="offer_text">⏳ Offer expiring soon.</p>
                <div class="features_top">
                    <div>🔓 Get Instant Access</div>
                    <div>🎥 Watch Tutorials Inside</div>
                    <div>📊 View All Strategies</div>
                    <div>🛡 Prepare For Tomorrow</div>
                </div>

                <p class="popup_instruction">How to Use / Instruction Video included inside</p>
                <div class="popup_unlock">
                    <h3>Unlock Everything:</h3>

                    <div class="popup_unlock_grid">
                        <span>✔ Trading Journal</span>
                        <span>✔ Games</span>
                        <span>✔ Calendar</span>
                        <span>✔ Insider Strategy</span>
                        <span>✔ Option Clock</span>

                        <span>✔ FII - DII Scanner</span>
                        <span>✔ TradeStream Live</span>
                        <span>✔ Calculator</span>
                        <span>✔ Sector Scope</span>
                        <span>✔ Option Apex</span>

                        <span>✔ Delivery Scanner</span>
                        <span>✔ Watchlist</span>
                        <span>✔ Market Pulse</span>
                        <span>✔ Swing Spectrum</span>
                        <span>✔ Trade Tutor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>