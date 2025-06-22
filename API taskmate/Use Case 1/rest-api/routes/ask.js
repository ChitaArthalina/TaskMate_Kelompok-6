const express = require('express');
const router = express.Router();
const db = require('../db');

// POST insert new question
router.post('/question', (req, res) => {
    const { id_user, category, question } = req.body;

    // 1. Cek atau insert kategori
    const getCategoryQuery = "SELECT id_kategori FROM kategori WHERE matakuliah = ?";
    db.query(getCategoryQuery, [category], (err, results) => {
        if (err) return res.status(500).json({ error: err.message });

        if (results.length > 0) {
            insertQuestion(results[0].id_kategori);
        } else {
            const insertCategoryQuery = "INSERT INTO kategori (matakuliah) VALUES (?)";
            db.query(insertCategoryQuery, [category], (err, result) => {
                if (err) return res.status(500).json({ error: err.message });
                insertQuestion(result.insertId);
            });
        }
    });

    function insertQuestion(id_kategori) {
        const insertQuery = `
            INSERT INTO pertanyaan (id_user, id_kategori, pertanyaan)
            VALUES (?, ?, ?)
        `;
        db.query(insertQuery, [id_user, id_kategori, question], (err) => {
            if (err) return res.status(500).json({ error: err.message });
            res.json({ message: 'Pertanyaan berhasil ditambahkan' });
        });
    }
});

module.exports = router;
