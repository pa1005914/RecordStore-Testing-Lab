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
            SELECT  r.title, r.artist, r.price, f.name
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