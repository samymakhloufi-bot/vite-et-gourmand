<?php
$activePage = 'Confirmation inscription';

require_once __DIR__ . '/login.php';
require_once __DIR__ . '/classes/Repository/UserRepository.php';

$token = $_GET['token'] ?? '';
$confirmationReussie = false;

if (is_string($token) && preg_match('/^[a-f0-9]{64}$/', $token)) {
    $userRepository = new UserRepository($pdo);
    $confirmationReussie = $userRepository->confirmRegistration($token);
}
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include __DIR__ . '/includes/head.php'; ?>

    <body>
        <?php include __DIR__ . '/includes/header.php'; ?>

        <main>
            <div class="nos-menus-banner">
                <div class="nos-menus-banner_diag"></div>
                <div class="nos-menus-banner_dark_diag"></div>
                <div class="nos-menus-banner_text">
                    <h1>Confirmation de <em>votre inscription</em></h1>
                </div>
            </div>

            <div class="succes-wrapper">
                <div class="succes-card">
                    <?php if ($confirmationReussie): ?>
                        <div class="succes-icon" aria-hidden="true">
                            <svg viewBox="0 0 32 32" fill="none">
                                <path d="M8 16 L13 21 L24 11" stroke="#F5F0E8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2>Votre inscription est confirmée !</h2>
                        <p>Votre adresse e-mail a été validée. Vous pouvez maintenant vous connecter.</p>
                        <div class="succes-btn">
                            <a href="<?= BASE_URL ?>/connexion.php?status=compte-active" class="btn-submit">Se connecter</a>
                        </div>
                    <?php else: ?>
                        <h2>Lien invalide ou expiré</h2>
                        <p>Ce lien de confirmation a déjà été utilisé ou sa durée de validité de 24 heures est dépassée.</p>
                        <p>Vous pouvez soumettre à nouveau le formulaire d'inscription avec la même adresse pour recevoir un nouveau lien.</p>
                        <div class="succes-btn">
                            <a href="<?= BASE_URL ?>/inscription.php" class="btn-submit">Recommencer l'inscription</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/includes/footer.php'; ?>
    </body>
</html>
