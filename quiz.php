<?php
// 1. Connexion à la BDD
require __DIR__ . '/repository/database.php';

$pdo = connectToDB();
// -------------------------------
// FONCTIONS
// -------------------------------

function getFirstQuestion(PDO $pdo)
{
    $sql = "SELECT * FROM questions WHERE first_question = 1 LIMIT 1";
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

function getQuestionById(int $id, PDO $pdo)
{
    $sql = "SELECT * FROM questions WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAnswersByQuestion(int $questionId, PDO $pdo)
{
    $sql = "SELECT * FROM answers WHERE id_question = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $questionId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNextStep(int $answerId, PDO $pdo)
{
    $sql = "SELECT id_next_question, id_result_game FROM answers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $answerId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// -------------------------------
// LOGIQUE DU QUIZ
// -------------------------------

// première arrivée sur la page → première question
if (!isset($_POST['answer_id'])) {
    $question = getFirstQuestion($pdo);
    $answers  = getAnswersByQuestion($question['id'], $pdo);
}

// une réponse a été envoyée
if (isset($_POST['answer_id'])) {

    $answerId = (int)$_POST['answer_id'];
    $next     = getNextStep($answerId, $pdo);

    if (!empty($next['id_next_question'])) {
        $question = getQuestionById($next['id_next_question'], $pdo);
        $answers  = getAnswersByQuestion($question['id'], $pdo);
    } elseif (!empty($next['id_result_game'])) {
        header('Location: result.php?id=' . $next['id_result_game']);
        exit;
    } else {
        die('Erreur : aucune suite possible pour cette réponse.');
    }
}

// une fois $question et $answers définis, on inclut le template
include __DIR__ . '/template/quiz.phtml';
