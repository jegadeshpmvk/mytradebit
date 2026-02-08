<?php

if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isSubscribed()) { ?>
    <div class="subscription_alert">

    </div>

    <div class="subscription_popup">
        <div class="subscription_popup_container">
            <h1 class="headline">Profits at your <span>fingertip</span> <a class="fa fa-close"></a></h1>
            <div class="popup_card">
                <div class="popup_badge">🔥 LIMITED OFFER</div>
                <div class="popup_logo">
                    <div class="popup_logo_circle">MTB</div>
                </div>
                <h2 class="plan_name">MY TRADE BIT</h2>
                <div class="plan_price">₹799<span>/-</span></div>
                <!--div class="old_price">Without Offer ₹2999</div-->
                <div class="plan_validity">Validity = <b>1 Year</b></div>
                <button class="buy_btn subscription_popup_buy_now">Buy Now</button>
                <p class="offer_text">⏳ Offer expiring soon. - Cost will be ₹2999 ⏳ </p>
                <div class="features_top">
                    <div>🚀 Instant Access</div>
                    <div>📊 Trading Dashboard</div>
                    <div>📈 All Strategies</div>
                    <div>🛡 Risk Managed Setups</div>
                </div>

                <!--p class="popup_instruction">How to Use / Instruction Video included inside</p>
                <div class="popup_unlock"-->
                <button class="buy_btn">Mastertool Feature</button>

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
            </div>
        </div>
    </div>

    <div class="subscription_payment_popup">
        <div class="subscription_payment_popup_container">
            <a class="fa fa-close"></a>
            <p class="offer_text"> Payment Gateway integration is in Progress!! <br> <br>
                Message 9876543210 to get the Mastertool Access <br> <br> Join with 100+ traders who are using My Trade Bit and become Profitable </p>
        </div>
    </div>
<?php } ?>