<?php 
require_once __DIR__ .'/../Entity/UserEntity.php';

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function hydrate(array|false|null $data): ?User{
    if(!$data) return null;
    return new User($data);
}

    public function findById(int $id): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
    }

    public function findByEmail(string $email): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
        }

    public function findByRememberToken(string $token): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$token]);
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($data);
        }

    public function findByResetToken(string $token): ?User{
        $tokenHash = hash('sha256', $token);

        $stmt = $this->pdo->prepare(
            "SELECT * FROM users
            WHERE reset_token = ?
            AND reset_token_expiry > NOW()
            AND actif = 1
            LIMIT 1"
        );
        $stmt->execute([$tokenHash]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->hydrate($data);
    }

    public function save(User $user): void{
        $stmt = $this->pdo->prepare("UPDATE users SET nom = ?, prenom = ?, tel = ?, adresse = ?, ville = ?, code_postal = ? WHERE id_user = ? ");
        $stmt->execute([
            $user->getNom(),
            $user->getPrenom(),
            $user->getTel(),
            $user->getAdresse(),
            $user->getVille(),
            $user->getCodePostal(),
            $user->getId()
        ]);
    }

    public function create(string $nom, string $prenom, string $tel, string $adresse, string $ville, string $codePostal, string $email, string $hashedPassword, string $token): void{
        $actif = 0; //compte inactif par défaut
        $tokenHash = hash('sha256', $token);

        $stmt = $this->pdo->prepare("INSERT INTO users(nom,prenom,tel,adresse,ville,code_postal,email,password,role, actif, registration_token,registration_token_expiry)VALUES(?,?,?,?,?,?,?,?,'user',?, ?,DATE_ADD(NOW(), INTERVAL 1 HOUR))");
        $stmt->execute([$nom, $prenom, $tel, $adresse, $ville,$codePostal,$email,$hashedPassword,$actif,$tokenHash]);
    }

    public function confirmRegistration(string $token): bool{
        $tokenHash = hash('sha256', $token);

        $stmt = $this->pdo->prepare("UPDATE users SET actif = 1, registration_token = NULL, registration_token_expiry = NULL 
                WHERE registration_token = ?
                AND registration_token_expiry > NOW() 
                AND actif = 0
                AND role = 'user'");
        $stmt->execute([$tokenHash]);
        return $stmt->rowCount() === 1;
    }

    public function updatePassword(int $id, string $hashedPassword):void{
        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET password = ?,
                remember_token = NULL,
                reset_token = NULL,
                reset_token_expiry = NULL
            WHERE id_user = ?"
        );
        $stmt->execute([$hashedPassword, $id]);
        }

    public function updateRememberToken(int $id, string $token): void {
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = ? WHERE id_user = ?");
        $stmt->execute([$token, $id]);
    }

    public function updateResetToken(int $id, string $token): void{
        $tokenHash = hash('sha256', $token);

        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR)
            WHERE id_user = ? AND actif = 1"
        );
        $stmt->execute([$tokenHash, $id]);
    }

    public function resetPassword(string $token, string $hashedPassword): bool{
        $tokenHash = hash('sha256', $token);

        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET password = ?,
                remember_token = NULL,
                reset_token = NULL,
                reset_token_expiry = NULL
            WHERE reset_token = ?
            AND reset_token_expiry > NOW()
            AND actif = 1"
        );
        $stmt->execute([$hashedPassword, $tokenHash]);

        return $stmt->rowCount() === 1;
    }

    public function emailExists(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetchColumn();
    }

    public function findAllEmployes(): array {
        $stmt = $this->pdo->query("SELECT id_user, nom, prenom, email, actif FROM users WHERE role = 'employe'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEmploye(string $nom, string $prenom, string $email, string $hashedPassword): void {
        $stmt = $this->pdo->prepare("INSERT INTO users(nom, prenom, email, password, role) VALUES(?,?,?,?,'employe')");
        $stmt->execute([$nom, $prenom, $email, $hashedPassword]);
    }

    public function toggleActif(int $id_user, int $actif): void {
        $stmt = $this->pdo->prepare("UPDATE users SET actif = ? WHERE id_user = ? AND role = 'employe'");
        $stmt->execute([$actif, $id_user]);
    }
}