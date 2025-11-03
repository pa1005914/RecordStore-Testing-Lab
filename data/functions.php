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
        ");

        $stmt->execute([
        ]);
        $result = $stmt->fetchAll(); 
        return $result;
    }

    function record_insert(): void {

    }