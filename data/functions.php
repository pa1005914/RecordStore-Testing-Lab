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