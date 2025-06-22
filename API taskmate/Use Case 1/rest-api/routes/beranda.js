const express = require('express');
const router = express.Router();
const db = require('../db');

router.get('/questions', (req, res) => {
    const query = `
        SELECT pertanyaan.id_pertanyaan, pertanyaan.pertanyaan, login.name, login.username
        FROM pertanyaan
        JOIN login ON pertanyaan.id_user = login.id_user
        ORDER BY pertanyaan.id_pertanyaan DESC
    `;

    db.query(query, (err, results) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(results);
    });
});

module.exports = router;
