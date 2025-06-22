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

app.post("/auth/login", async (req, res) => {
    const { username, password } = req.body;

    if (!username || !password) {
        return res.status(400).json({ message: "Username dan password wajib diisi!" });
    }

    try {
        const db = await mysql.createConnection(paramdb);
        const [rows] = await db.execute("SELECT * FROM login WHERE username = ?", [username]);
        await db.end();

        const user = rows[0];

        if (!user) {
            return res.status(404).json({ message: "User tidak ditemukan!" });
        }

        // Ganti prefix $2y$ ke $2b$
        let hashed = user.password;
        if (hashed.startsWith("$2y$")) {
            hashed = "$2b$" + hashed.substring(4);
        }

        const match = await bcrypt.compare(password, hashed);

        if (!match) {
            return res.status(401).json({ message: "Password salah!" });
        }

        res.status(200).json({
            message: "Login sukses",
            id_user: user.id_user,
            username: user.username,
            name: user.name
        });

    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Terjadi kesalahan server" });
    }
});

app.listen(PORT, () => {
    console.log(`API berjalan di http://localhost:${PORT}`);
});
