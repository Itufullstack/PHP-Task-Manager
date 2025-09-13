<?php
require_once 'includes/config.php';

if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"] === null){
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$tasks = [];
$sql = "SELECT id, title, description, status, created_at FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC";
if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    if($stmt->execute()){
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
unset($stmt);
?>

<?php include 'includes/header.php'; ?>

    <h2>My Task Dashboard</h2>
    <p class="text-muted">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>! Here are your tasks.</p>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Add a New Task</h5>
        </div>
        <div class="card-body">
            <form action="tasks.php" method="post">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label for="taskTitle" class="form-label">Task Title*</label>
                    <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="e.g., Buy groceries">
                </div>
                <div class="mb-3">
                    <label for="taskDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="taskDescription" name="description" rows="2" placeholder="e.g., Milk, Bread, Eggs"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Add Task</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">My To-Do List</h5>
        </div>
        <div class="card-body">
            <?php if (count($tasks) > 0): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($tasks as $task): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <form action="tasks.php" method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <input type="hidden" name="new_status" value="<?php echo $task['status'] ? '0' : '1'; ?>">
                                    <button type="submit" class="btn btn-sm <?php echo $task['status'] ? 'btn-outline-success' : 'btn-outline-secondary'; ?> me-2">
                                        <?php echo $task['status'] ? '✓ Completed' : 'Mark Complete'; ?>
                                    </button>
                                </form>

                                <span class="<?php echo $task['status'] ? 'text-decoration-line-through text-muted' : ''; ?>">
                                    <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                                    <?php if (!empty($task['description'])): ?>
                                        <br><span class="text-muted"><?php echo htmlspecialchars($task['description']); ?></span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <form action="tasks.php" method="post" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-muted">You don't have any tasks yet. Add one above!</p>
            <?php endif; ?>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>