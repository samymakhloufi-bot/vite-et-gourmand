<?php 
require_once __DIR__ .'/../Entity/UserEntity.php';

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function hydrate(?array $data): ?User{
        if(!$data) return null;
        return new User($data);
    }

    public function findById(int $id): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->execute([$id]);
        return $this->hydrate($stmt->fetch());
    }

    public function findByEmail(string $email): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $this->hydrate($stmt->fetch());
        }

    public function findByRememberToken(string $token): ?User{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $stmt->execute([$token]);
        return $this->hydrate($stmt->fetch());
        }

    public function save(User $user): void{
        $stmt = $this->pdo->prepare("UPDATE users SET nom = ?, prenom = ?, tel = ?, adresse = ?, ville = ?, code_postal = ? WHERE id_users = ? ");
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

    public function create(string $nom, string $prenom, string $tel, string $adresse, string $ville, string $codePostal, string $email, string $hashedPassword): void{
        $stmt = $this->pdo->prepare("INSERT INTO users(nom,prenom,tel,adresse,ville,code_postal,email,password,role)VALUES(?,?,?,?,?,?,?,?,'user')");
        $stmt->execute([$nom, $prenom, $tel, $adresse, $ville,$codePostal,$email,$hashedPassword]);
    }

    public function updatePassword(int $id, string $hashedPassword):void{
        $stmt = $this->pdo->prepare("UPDATE users SET password = ?, remember_token = NULL WHERE id_user = ? ");
        $stmt->execute([$hashedPassword, $id]);
        }

    public function updateRememberToken(int $id, string $token): void {
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = ? WHERE id_user = ?");
        $stmt->execute([$token, $id]);
    }

    public function emailExists(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetchColumn();
    }
}