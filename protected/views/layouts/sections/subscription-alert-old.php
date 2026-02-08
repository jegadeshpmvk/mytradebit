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
                <!--div class="old_price">Without Offer ₹2999</div-->
                <div class="plan_validity">Validity = <b>1 Year</b></div>
                <button class="buy_btn">Buy Now</button>
                <p class="offer_text">⏳ Offer expiring soon. -  Cost will be ₹2999 ⏳ </p>
                <div class="features_top">
                    <div>🔓 Get Instant Access</div>
                    <div>🎥 Mastertool for Trading</div>
                    <div>📊 View All Strategies</div>
                    <div>🛡 Trade at your Own Pace</div>
                </div>

                <!--p class="popup_instruction">How to Use / Instruction Video included inside</p>
                <div class="popup_unlock"-->
                    <button class="buy_btn">Mastertool Feature</button>

                    <div class="popup_unlock_grid">
                        <span>✔ Global Sentiments</span>
                        <span>✔ Pre Market Performance</span>
                        <span>✔ Live Market Performance</span>
                        <span>✔ All Sector Heatmap</span>
                        <span>✔ Options & Futures Board</span>

                        <span>✔ FII - DII Sentiment</span>
                        <span>✔ Clarity Setup Before Entry</span>
                        <span>✔ High Momentum Stocks</span>
                        <span>✔ Options Scope</span>
                        <span>✔ Granular OI Analysis</span>

                        <span>✔ Options Sentiment</span>
                        <span>✔ Stocks Buzz</span>
                        <span>✔ Intraday Setups</span>
                        <span>✔ Positional Setups</span>
                        
                        
                        </div>
                        <p class="offer_text"> Payment Gateway integration is in Progress!! <br> <br>
Message 9876543210 to get the Mastertool Access <br> <br> Join with 100+ traders who are using My Trade Bit and become Profitable </p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>