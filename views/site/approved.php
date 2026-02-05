<?php
use app\models\User;
?>
<div class="waiting-container">

    <div class="waiting-box">
        <img src="https://c8.alamy.com/compit/b6e3ne/sala-di-attesa-simbolo-contro-uno-sfondo-bianco-b6e3ne.jpg" class="waiting-img">

        <h1 class="waiting-title">Attendere prego</h1>
        <p class="waiting-text">
            La tua richiesta è stata ricevuta.<br>
            Un nostro operatore la valuterà al più presto.
        </p>

        <div class="waiting-loader"></div>
    </div>

</div>

<style>
/* Contenitore principale */
.waiting-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
    background: #f5f7fa;
    font-family: "Segoe UI", sans-serif;
}

/* Box centrale */
.waiting-box {
    background: #ffffff;
    padding: 40px 50px;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    text-align: center;
    max-width: 420px;
    border-top: 5px solid #0057b8;
}

/* Immagine */
.waiting-img {
    width: 180px;
    margin-bottom: 20px;
}

/* Titolo */
.waiting-title {
    font-size: 28px;
    font-weight: 700;
    color: #003f88;
    margin-bottom: 10px;
}

/* Testo */
.waiting-text {
    font-size: 16px;
    color: #555;
    margin-bottom: 25px;
}

/* Loader animato */
.waiting-loader {
    width: 45px;
    height: 45px;
    border: 5px solid #e0e0e0;
    border-top-color: #0057b8;
    border-radius: 50%;
    margin: 0 auto;
    animation: spin 1s linear infinite;
}

/* Animazione */
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
