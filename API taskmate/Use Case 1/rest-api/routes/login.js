const express = require('express');
const router = express.Router();
const db = require('../db');

// Get user by username
router.get('/:username', (req, res) => {
    const username = req.params.username;
    const query = "SELECT * FROM login WHERE username = ?";
    db.query(query, [username], (err, results) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json(results[0]);
    });
});

// Register new user
router.post('/register', (req, res) => {
    const { name, username, password } = req.body;
    const query = "INSERT INTO login (name, username, password) VALUES (?, ?, ?)";
    db.query(query, [name, username, password], (err, result) => {
        if (err) return res.status(500).json({ error: err.message });
        res.json({ insertedId: result.insertId });
    });
});

module.exports = router;
