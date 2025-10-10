/**
 * @swagger
 * components:
 *   schemas:
 *     Game:
 *       type: object
 *       required:
 *         - ownerPlayerId
 *         - title
 *         - background
 *         - era
 *         - yearInGame
 *         - accessCode
 *         - locked
 *         - scheduled
 *         - started
 *         - finished
 *       properties:
 *         gameid:
 *           type: number
 *           description: The auto-generated id of the game
 *         ownerPlayerId:
 *           type: number
 *           description: The player this game is assigned to
 *         title:
 *           type: string
 *           description: The title of the game
 *         background:
 *           type: string
 *           description: Background to this game
 *         era:
 *           type: string
 *           description: One of the eras STAR LEAGUE, SUCCESSION WARS, CLAN INVASION, CIVIL WAR, JIHAD, DARK AGE, ILCLAN
 *         yearInGame:
 *           type: string
 *           description: The year in the BTU timeline
 *         accessCode:
 *           type: string
 *           description: Access code
 *         locked:
 *           type: boolean
 *           description: Whether the game is locked (no one can join anymore)
 *         scheduled:
 *           type: string
 *           format: date
 *           description: When the game will start
 *         started:
 *           type: string
 *           format: date
 *           description: Whether the game has been finished
 *         finished:
 *           type: string
 *           format: date
 *           description: Whether the game has been finished
 *         createdAt:
 *           type: string
 *           format: date
 *           description: The date the game was added
 *         player:
 *           type: array
 *           items:
 *             $ref: "#/components/schemas/Player"
 *       example:
 *         gameid: 543
 *         ownerPlayerId: 2
 *         title: Northwind Planetary Assault
 *         background: The planetary assault on Northwind by Clan Snow Raven
 *         era: CLAN INVASION
 *         yearInGame: 3052
 *         accessCode: xxx
 *         locked: true
 *         scheduled: 2024-12-06T08:00:00.000Z
 *         started: 2024-12-06T08:00:00.000Z
 *         finished: null
 *         createdAt: 2024-11-29T04:05:06.157Z
 */

/**
 * @swagger
 * tags:
 *   name: Game
 *   description: The ASCard API
 * /games:
 *   get:
 *     summary: Lists all games
 *     tags: [Games]
 *     responses:
 *       200:
 *         description: The list of all games
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Game'
 *   post:
 *     summary: Create a new game
 *     tags: [Games]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Game'
 *     responses:
 *       200:
 *         description: The created game.
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Game'
 *       500:
 *         description: Server error
 * /games/{id}:
 *   get:
 *     summary: Get the game by id
 *     tags: [Games]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: string
 *         required: true
 *         description: The game id
 *     responses:
 *       200:
 *         description: The game response by id
 *         contens:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Game'
 *       404:
 *         description: The game was not found
 *   put:
 *    summary: Update the game by the id
 *    tags: [Games]
 *    parameters:
 *      - in: path
 *        name: id
 *        schema:
 *          type: string
 *        required: true
 *        description: The game id
 *    requestBody:
 *      required: true
 *      content:
 *        application/json:
 *          schema:
 *            $ref: '#/components/schemas/Game'
 *    responses:
 *      200:
 *        description: The game was updated
 *        content:
 *          application/json:
 *            schema:
 *              $ref: '#/components/schemas/Game'
 *      404:
 *        description: The game was not found
 *      500:
 *        description: Server error
 *   delete:
 *     summary: Remove the game by id
 *     tags: [Games]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: string
 *         required: true
 *         description: The game id
 *     responses:
 *       200:
 *         description: The game was deleted
 *       404:
 *         description: The game was not found
 */
const { logger } = require("../logger.js");
const db = require("../db.js");

const express = require("express");
const router = express.Router();

const SECRET_KEY = require("../secret");
const verifyToken = require("../auth");

router.get("/", async (req, res) => {
  //router.get("/", verifyToken, async (req, res) => {

  try {
    var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;
    const games = await db.pool.query("SELECT * FROM asc_game");
    logger.info("List of all games requested from ip: " + ip);

    res.status(200).send(games);
  } catch (err) {
    throw err;
  }
});

/* router.get("/:id", async (req, res) => {
  var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;
  const games = await db.pool.query("SELECT * FROM asc_game");
  logger.info("Game with id " + req.params.id + " requested from ip: " + ip);

  let game = games.find(function (item) {
    return item.gameid == req.params.id;
  });

  game ? res.status(200).json(game) : res.sendStatus(404);
}); */

router.get("/:id", async (req, res) => {
  var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;
  const games = await db.pool.query(
    "SELECT * FROM asc_game g, asc_player p WHERE g.gameId = p.gameId AND g.gameId = ?",
    [req.params.id]
  );
  logger.info("Game with id " + req.params.id + " requested from ip: " + ip);

  let game = games.find(function (item) {
    return item.gameid == req.params.id;
  });

  game ? res.status(200).json(game) : res.sendStatus(404);
});

router.post("/", async (req, res) => {
  const {
    ownerPlayerId,
    title,
    background,
    era,
    yearInGame,
    accessCode,
    locked,
    scheduled,
    started,
    finished,
  } = req.body;
  const games = await db.pool.query("SELECT * FROM asc_game");
  var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;

  let game = {
    gameid: games.length + 1,
    ownerPlayerId: ownerPlayerId,
    title: title,
    background: background,
    era: era,
    yearInGame: yearInGame,
    accessCode: accessCode,
    locked: locked,
    scheduled: scheduled,
    started: started,
    finished: finished !== undefined ? finished : null,
    createdAt: new Date(),
  };

  /*   db.pool.query(
    "INSERT INTO asc_game VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
    Object.values(game)
  ); */

  //logger.info("Game with id " + game.gameid + " created from ip: " + ip);
  logger.info("NOT CREATING ANYTHING! CHECK CODE!");

  res.status(201).json(game);
});

router.put("/:id", async (req, res) => {
  var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;
  const games = await db.pool.query("SELECT * FROM asc_game");

  let game = games.find(function (item) {
    return item.gameid == req.params.id;
  });

  if (game) {
    var con = "";
    var updateQueryString = "UPDATE asc_game SET ";
    var data = req.body;
    for (const [key, value] of Object.entries(data)) {
      if (typeof value === "string" || value instanceof String) {
        updateQueryString = updateQueryString + con + `${key}='${value}'` + " ";
      } else {
        updateQueryString = updateQueryString + con + `${key}=${value}` + " ";
      }
      if (con == "") {
        con = ",";
      }
    }
    updateQueryString = updateQueryString + " WHERE gameid=" + game.gameid;

    /*     db.pool.query(updateQueryString, (error, result) => {
      if (error) throw error;
      logger.info("Game with id " + game.gameid + " updated from ip: " + ip);
    }); */

    //logger.info(updateQueryString);
    //logger.info("Game with id " + game.gameid + " updated from ip: " + ip);
    logger.info("NOT UPDATING ANYTHING! CHECK CODE!");

    res.sendStatus(204).json(game);
  } else {
    res.sendStatus(404);
  }
});

router.delete("/:id", async (req, res) => {
  var ip = req.headers["x-forwarded-for"] || req.socket.remoteAddress || null;
  const games = await db.pool.query("SELECT * FROM asc_game");

  let game = games.find(function (item) {
    return item.gameid == req.params.id;
  });

  if (game) {
    /*     db.pool.query(
      "DELETE FROM asc_game WHERE gameid = ?",
      [game.gameid],
      (error, result) => {
        if (error) throw error;
        logger.info("Game with id " + game.gameid + " deleted from ip: " + ip);
      }
    ); */

    //logger.info(updateQueryString);
    //logger.info("Game: " + game.gameid);
    logger.info("NOT DELETING ANYTHING! CHECK CODE!");
  } else {
    return res.sendStatus(404);
  }

  res.sendStatus(204);
});

module.exports = router;
