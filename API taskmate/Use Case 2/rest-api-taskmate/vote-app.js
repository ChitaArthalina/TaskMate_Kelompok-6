const express = require("express");
const mysql = require("mysql2/promise");
const app = express();
const PORT = 8000;

const paramdb = {
    host: "localhost",
    port: "3306",
    user: "root",
    password: "",
    database: "taskmate"
};

const router = express.Router();
app.use(express.json());

// GET /votes/:id_jawaban - Mendapatkan votes berdasarkan id_jawaban
const getVotes = async (req, res) => {
    const { id_jawaban } = req.params;
    
    try {
        const db = await mysql.createConnection(paramdb);
        const sql = "SELECT upvote, downvote FROM votes WHERE id_jawaban = ?";
        const [rows] = await db.execute(sql, [id_jawaban]);
        db.end();
        
        const result = rows[0] || { upvote: 0, downvote: 0 };
        res.status(200).json(result);
    } catch(error) {
        return res.status(500).json({error});
    }
};

// GET /votes/sorted - Mendapatkan semua votes yang diurutkan berdasarkan score
const getAllVotesSorted = async (req, res) => {
    try {
        const db = await mysql.createConnection(paramdb);
        const sql = `
            SELECT id_jawaban, upvote, downvote, (upvote - downvote) as score 
            FROM votes 
            ORDER BY score DESC, upvote DESC
        `;
        const [rows] = await db.execute(sql);
        db.end();
        
        const votes = {};
        rows.forEach(row => {
            votes[row.id_jawaban] = {
                upvote: row.upvote,
                downvote: row.downvote,
                score: row.score
            };
        });
        
        res.status(200).json(votes);
    } catch(error) {
        return res.status(500).json({error});
    }
};

// GET /votes/order - Mendapatkan urutan id_jawaban berdasarkan score
const getAnswerOrder = async (req, res) => {
    try {
        const db = await mysql.createConnection(paramdb);
        const sql = `
            SELECT id_jawaban, (upvote - downvote) as score 
            FROM votes 
            ORDER BY score DESC, upvote DESC
        `;
        const [rows] = await db.execute(sql);
        db.end();
        
        const order = rows.map(row => row.id_jawaban);
        res.status(200).json({ order });
    } catch(error) {
        return res.status(500).json({error});
    }
};

// GET /votes/detail/:id_jawaban - Lihat data lengkap vote + identitas user
const getVoteDetail = async (req, res) => {
    const { id_jawaban } = req.params;
    try {
        const db = await mysql.createConnection(paramdb);
        const sql = `
            SELECT l.name, l.username, v.id_jawaban, v.upvote, v.downvote, (v.upvote - v.downvote) AS score,
                   j.jawaban, j.id_pertanyaan
            FROM votes v
            JOIN jawaban j ON v.id_jawaban = j.id_jawaban
            JOIN login l ON j.id_user = l.id_user
            WHERE v.id_jawaban = ?
        `;
        const [rows] = await db.execute(sql, [id_jawaban]);
        db.end();

        if (rows.length === 0) {
            return res.status(404).json({ message: "Jawaban tidak ditemukan" });
        }

        res.status(200).json(rows[0]);
    } catch (error) {
        return res.status(500).json({ error });
    }
};


// POST /votes/:id_jawaban/upvote - Memberikan upvote
const upvote = async (req, res) => {
    const { id_jawaban } = req.params;
    
    try {
        const db = await mysql.createConnection(paramdb);
        
        // Pastikan row exists
        await ensureVoteRow(db, id_jawaban);
        
        const sql = "UPDATE votes SET upvote = upvote + 1 WHERE id_jawaban = ?";
        await db.execute(sql, [id_jawaban]);
        db.end();
        
        res.status(200).json({ message: "Upvote berhasil" });
    } catch(error) {
        return res.status(500).json({error});
    }
};

// POST /votes/:id_jawaban/downvote - Memberikan downvote
const downvote = async (req, res) => {
    const { id_jawaban } = req.params;
    
    try {
        const db = await mysql.createConnection(paramdb);
        
        // Pastikan row exists
        await ensureVoteRow(db, id_jawaban);
        
        const sql = "UPDATE votes SET downvote = downvote + 1 WHERE id_jawaban = ?";
        await db.execute(sql, [id_jawaban]);
        db.end();
        
        res.status(200).json({ message: "Downvote berhasil" });
    } catch(error) {
        return res.status(500).json({error});
    }
};


// Helper function untuk memastikan vote row exists
const ensureVoteRow = async (db, id_jawaban) => {
    const checkSql = "SELECT 1 FROM votes WHERE id_jawaban = ?";
    const [rows] = await db.execute(checkSql, [id_jawaban]);
    
    if (rows.length === 0) {
        const insertSql = "INSERT INTO votes (id_jawaban, upvote, downvote) VALUES (?, 0, 0)";
        await db.execute(insertSql, [id_jawaban]);
    }
};

// Test database connection
const tesDatabase = async (req, res) => {
    try {
        const db = await mysql.createConnection(paramdb);
        await db.ping();
        db.end();
        res.status(200).json({status: "Database connection OK"});
    } catch(error) {
        res.status(500).json({error});
    }
};

// Routes - urutan penting untuk menghindari konflik
router.get('/', (req, res) => {
    res.status(200).send('Vote API is running');
});

router.get('/tes', tesDatabase);
router.get('/votes/sorted', getAllVotesSorted);
router.get('/votes/order', getAnswerOrder);
router.get('/votes/detail/:id_jawaban', getVoteDetail);
router.get('/votes/:id_jawaban', getVotes);
router.post('/votes/:id_jawaban/upvote', upvote);
router.post('/votes/:id_jawaban/downvote', downvote);

app.use('/', router);

app.listen(PORT, () => {
    console.log(`Vote API Server is running on port ${PORT}`);
});