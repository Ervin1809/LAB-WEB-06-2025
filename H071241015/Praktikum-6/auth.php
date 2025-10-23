<?php
include_once 'config.php';

function authenticateUser($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, username, password, role, project_manager_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['project_manager_id'] = $user['project_manager_id'];
            
            return true;
        }
    }
    
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function isSuperAdmin() {
    return hasRole('Super Admin');
}

function isProjectManager() {
    return hasRole('Project Manager');
}

function isTeamMember() {
    return hasRole('Team Member');
}

function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

function getUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

function getUserProjectManagerId() {
    return isset($_SESSION['project_manager_id']) ? $_SESSION['project_manager_id'] : null;
}

function canAccessProject($projectId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT manager_id FROM projects WHERE id = ?");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $project = $result->fetch_assoc();
        $projectManagerId = $project['manager_id'];
        
        if (isSuperAdmin()) {
            return true;
        }
        
        if (isProjectManager() && getUserId() == $projectManagerId) {
            return true;
        }
        
        if (isTeamMember()) {
            $userId = getUserId();
            $stmt2 = $conn->prepare("SELECT t.id FROM tasks t WHERE t.project_id = ? AND t.assigned_to = ?");
            $stmt2->bind_param("ii", $projectId, $userId);
            $stmt2->execute();
            $taskResult = $stmt2->get_result();
            
            if ($taskResult->num_rows > 0) {
                return true;
            }
        }
    }
    
    return false;
}

function logout() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    
    header('Location: login.php');
    exit();
}
?>