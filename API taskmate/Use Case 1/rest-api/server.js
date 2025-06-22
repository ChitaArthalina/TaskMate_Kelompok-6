const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

const loginRoutes = require('./routes/login');
const berandaRoutes = require('./routes/beranda');
const askRoutes = require('./routes/ask');
const discussionRoutes = require('./routes/discussion');

app.use(bodyParser.json());

app.use('/api/login', loginRoutes);
app.use('/api/beranda', berandaRoutes);
app.use('/api/ask', askRoutes);
app.use('/api/discussion', discussionRoutes);

app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
