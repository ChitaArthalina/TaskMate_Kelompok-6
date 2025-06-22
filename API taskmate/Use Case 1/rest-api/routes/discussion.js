const express = require('express');
const router = express.Router();
const db = require('../db');

router.get('/latest/:id_user', (req, res) => {
    const id_user = req.params.id_user;
    const query = `
        SELECT pertanyaan.*, login.username, kategori.matakuliah AS nama_kategori
        FROM pertanyaan
        JOIN login ON pertanyaan.id_user = login.id_user
        JOIN kategori ON pertanyaan.id_kategori = kategori.id_kategori
        WHERE pertanyaan.id_user = ?
        ORDER BY pertanyaan.id_pertanyaan DESC
        LIMIT 1
    `;

    db.query(query, [id_user], (err, results) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(results[0]);
    });
});

module.exports = router;
