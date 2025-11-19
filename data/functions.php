<?php
    function formats_all(): array{
        $pdo = get_pdo();
        $stmt = $pdo->query("
            SELECT * FROM `formats` ORDER BY name;
        ");
        return $stmt->fetchAll();
        
    }

    function records_all(): array{
        $pdo = get_pdo();
        $stmt = $pdo->prepare("
            SELECT r.id, r.title, r.artist, r.price, f.name
            FROM `records` r
            JOIN formats f ON r.format_id = f.id
            ORDER BY created_at DESC
        ");

        $stmt->execute([
        ]);
        $result = $stmt->fetchAll(); 
        return $result;
    }

    function record_insert($title, $artist, $price, $format_id): void {
        $pdo = get_pdo();
        $stmt = $pdo->prepare("INSERT INTO records (title, artist, price, format_id) VALUES (:title, :artist, :price, :format_id)");

        $stmt->execute([':title' => $title, ':artist' => $artist, ':price' => $price, ':format_id' => $format_id]);
        if ($stmt->rowCount() > 0){
            echo("Insert success: true, rows: 1");
        }
    }

    function record_get(int $id): ?array {
        $pdo = get_pdo();
        $sql = "
                SELECT r.id, r.title, r.artist, r.price, r.genre_id, g.name AS genre_name, f.name AS format_id  
                FROM records r
                JOIN formats f ON f.id = r.format_id
                JOIN genres g ON g.id = r.genre_id
                WHERE r.id = :id
                LIMIT 1
            ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function record_delete(int $id): int {
        $pdo = get_pdo();
        $stmt = $pdo->prepare("DELETE FROM records WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount(); // 1 if deleted, 0 if not found
    }

    function record_update(int $id, string $title,string $artist,float $price, int $format_id){
        
    }
    #parameters username full_name password hash
    #inserts a new user into the users table
    function user_create(string $username, string $full_name, string $hash): void {
        $pdo = get_pdo();
        $sql = "INSERT INTO users (username, full_name, password_hash)
                VALUES (:u, :f, :p)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':u'=>$username, ':f'=>$full_name, ':p'=>$hash]);
    }

    #parameters username
    #finds a user in the users table by username
    #returns the row with the user or null if one is not found
    function user_find_by_username(string $username): ?array {
        $pdo = get_pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u");
        $stmt->execute([':u'=>$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    #parameters ids
    #gets an array of records by id with the araibutes id title artist price and name from the fromats table
    #returns an associative array of all of the rows of the input ids
    function records_by_ids(array $ids): array {
        if (empty($ids)) return [];
        $pdo = get_pdo();
         $ph = implode(',', array_fill(0, count($ids), '?')); //makes the ids a string for the sql
        $sql = "SELECT r.id, r.title, r.artist, r.price, f.name
                FROM records r
                JOIN formats f ON r.format_id = f.id
                WHERE r.id IN ($ph)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    #parameters user_id record_id
    #creates a new record in the purchases table for a user of when and what record was purchased
    function purchase_create(int $user_id, int $record_id): void {
        $pdo = get_pdo();
        $sql = "INSERT INTO purchases (user_id, record_id, purchase_date)
                VALUES (:u, :r, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':u'=>$user_id, ':r'=>$record_id]);
    }