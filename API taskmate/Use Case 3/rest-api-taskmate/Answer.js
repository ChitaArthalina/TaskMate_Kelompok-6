const express = require("express");
const mysql = require("mysql2/promise");
const bcrypt = require("bcrypt");
const cors = require("cors");

const app = express();
const PORT = 8000;

const paramdb = {
    host: "localhost",
    port: "3306",
    user: "root",
    password: "",
    database: "taskmate"
};

app.use(cors());
app.use(express.json());

app.post("/jawaban", async (req, res) => {
    const { id_user, id_pertanyaan, jawaban } = req.body;

    if (!id_user || !id_pertanyaan || !jawaban) {
        return res.status(400).json({ message: "Data tidak lengkap!" });
    }

    try {
        const db = await mysql.createConnection(paramdb);
        const [result] = await db.execute(
            "INSERT INTO jawaban (id_user, id_pertanyaan, jawaban) VALUES (?, ?, ?)",
            [id_user, id_pertanyaan, jawaban]
        );
        await db.end();

        res.status(201).json({ message: "Jawaban berhasil ditambahkan!" });
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Gagal menyimpan jawaban" });
    }
});

app.get("/diskusi/:id_pertanyaan", async (req, res) => {
    const { id_pertanyaan } = req.params;

    try {
        const db = await mysql.createConnection(paramdb);

        // Ambil data pertanyaan + user-nya
        const [pertanyaanRows] = await db.execute(`
            SELECT pertanyaan.pertanyaan, login.name, login.username, login.foto
            FROM pertanyaan
            JOIN login ON pertanyaan.id_user = login.id_user
            WHERE pertanyaan.id_pertanyaan = ?
        `, [id_pertanyaan]);

        // Kalau pertanyaannya nggak ketemu
        if (pertanyaanRows.length === 0) {
            await db.end();
            return res.status(404).json({ message: "Pertanyaan tidak ditemukan" });
        }

        // Ambil semua jawaban dari user lain
        const [jawabanRows] = await db.execute(`
            SELECT login.username, login.name, login.foto, jawaban.jawaban
            FROM jawaban
            JOIN login ON jawaban.id_user = login.id_user
            WHERE jawaban.id_pertanyaan = ?
        `, [id_pertanyaan]);

        await db.end();

        // Gabungkan menjadi satu JSON response
        res.status(200).json({
            pertanyaan: pertanyaanRows[0],
            jawaban: jawabanRows
        });

    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Gagal mengambil data diskusi" });
    }
});

app.listen(PORT, () => {
    console.log(`API berjalan di http://localhost:${PORT}`);
});

