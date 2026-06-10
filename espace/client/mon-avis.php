
<span class="toast" id="toast-avis"></span>

<h2>Votre avis compte pour nous !</h2>

<form action="<?= BASE_URL ?>/traitement/submit-avis.php" method="post" id="form-avis">
    <textarea name="contenu" placeholder=" Donner votre avis ...." required></textarea>

    <div class="star-rating">
            <input type="radio" name="note" id="star5" value="5" checked><label for="star5">★</label>
            <input type="radio" name="note" id="star4" value="4"><label for="star4">★</label>
            <input type="radio" name="note" id="star3" value="3"><label for="star3">★</label>
            <input type="radio" name="note" id="star2" value="2"><label for="star2">★</label>
            <input type="radio" name="note" id="star1" value="1"><label for="star1">★</label>
    </div>

    <button type="submit" name="submit-avis">Envoyer mon avis</button>

</form>

