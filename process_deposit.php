<?php
session_start();
include 'connection.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log function to write messages to log.txt
function logMessage($message) {
    $logFile = 'log.txt';
    $currentDateTime = date('Y-m-d H:i:s');
    $logMessage = "[{$currentDateTime}] {$message}\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Get current date
$currentDate = date('Y-m-d');

// Process investments every day
$processQuery = "SELECT * FROM investments WHERE status = 'pending'";
if ($stmt = $conn->prepare($processQuery)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($investment = $result->fetch_assoc()) {
        $investment_id = $investment['id'];
        $user_id = $investment['user_id']; // Add user_id to get the user associated with the investment
        $plan_id = $investment['plan_id'];
        $investment_amount = $investment['amount'];
        $current_earnings = $investment['earnings'];
        $total_earnings = $investment['total_earnings'];
        $created_at = $investment['created_at']; // Assuming created_at is a timestamp of when the investment was made

        // Fetch the plan details
        $planQuery = "SELECT * FROM investment_plan WHERE id = ?";
        if ($stmtPlan = $conn->prepare($planQuery)) {
            $stmtPlan->bind_param("i", $plan_id);
            $stmtPlan->execute();
            $planResult = $stmtPlan->get_result();
            $plan = $planResult->fetch_assoc();

            $roi = $plan['roi']; // The ROI percentage
            $roi_max = $plan['roi_max']; // The max ROI
            $duration_timeframe = $plan['duration_timeframe']; // Duration in days
            $earning_duration = $plan['earning_duration']; // Earning frequency (e.g., daily, hourly)

            // Calculate the number of days since the investment was created
            $created_at_date = new DateTime($created_at);
            $currentDateTime = new DateTime($currentDate);
            $interval = $created_at_date->diff($currentDateTime);
            $daysSinceInvestment = $interval->days;

            // If the investment has reached the maximum duration_timeframe, stop the investment
            if ($daysSinceInvestment >= $duration_timeframe) {
                // Calculate the total earnings after reaching the duration time frame
                $finalEarnings = $current_earnings + $total_earnings;

                // Update the total earnings field in the investment and set completed_at date
                $updateTotalEarningsQuery = "UPDATE investments SET total_earnings = ?, status = 'completed', completed_at = ? WHERE id = ?";
                if ($stmtUpdateTotalEarnings = $conn->prepare($updateTotalEarningsQuery)) {
                    $completed_at = date('Y-m-d H:i:s'); // Get the current date and time when the investment is completed
                    $stmtUpdateTotalEarnings->bind_param("dsi", $finalEarnings, $completed_at, $investment_id);
                    $stmtUpdateTotalEarnings->execute();
                    logMessage("Investment {$investment_id} completed after reaching the timeframe with total earnings: {$finalEarnings}. Completed at: {$completed_at}");

                    // After marking the investment as completed, update the user's balance
                    // Fetch the current balance of the user
                    $userQuery = "SELECT balance FROM users WHERE user_id = ?"; // Changed from 'id' to 'user_id'
                    if ($stmtUser = $conn->prepare($userQuery)) {
                        $stmtUser->bind_param("i", $user_id); // Use user_id here
                        $stmtUser->execute();
                        $userResult = $stmtUser->get_result();
                        if ($user = $userResult->fetch_assoc()) {
                            $userBalance = $user['balance'];

                            // Add the total earnings to the user's balance
                            $newBalance = $userBalance + $finalEarnings;

                            // Update the user's balance
                            $updateUserBalanceQuery = "UPDATE users SET balance = ? WHERE user_id = ?"; // Changed from 'id' to 'user_id'
                            if ($stmtUpdateBalance = $conn->prepare($updateUserBalanceQuery)) {
                                $stmtUpdateBalance->bind_param("di", $newBalance, $user_id); // Use user_id here
                                $stmtUpdateBalance->execute();
                                logMessage("User {$user_id}'s balance updated. New balance: {$newBalance}");
                            } else {
                                logMessage("Error updating user {$user_id}'s balance.");
                            }
                        }
                    }
                }
            } else {
                // Calculate the daily earnings based on ROI, ensuring it does not exceed roi_max
                $dailyProfit = ($investment_amount * ($roi / 100)) / 365; // ROI per day

                // Ensure profit does not exceed max ROI
                $maxPossibleProfit = ($investment_amount * ($roi_max / 100)) / 365; // Max profit per day
                $newEarnings = $current_earnings + min($dailyProfit, $maxPossibleProfit);

                // Update the current earnings of the investment
                $updateEarningsQuery = "UPDATE investments SET current_earnings = ? WHERE id = ?";
                if ($stmtUpdateEarnings = $conn->prepare($updateEarningsQuery)) {
                    $stmtUpdateEarnings->bind_param("di", $newEarnings, $investment_id);
                    $stmtUpdateEarnings->execute();
                    logMessage("Investment {$investment_id} earnings updated. New earnings: {$newEarnings}");
                }
            }
        }
    }
    $stmt->close();
}
?>
