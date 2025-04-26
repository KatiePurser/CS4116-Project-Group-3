function deleteUser(userId, reportId) {
    fetch('scripts/delete_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            report_id: reportId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User deleted successfully!');
                window.location.reload();
            } else {
                alert('Failed to delete user.');
            }
        })
}

function banUser(userId, bannedBy, banReason, reportId, targetType, targetId) {
    fetch('scripts/ban_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            banned_by: bannedBy,
            ban_reason: banReason,
            report_id: reportId,
            target_type: targetType,
            target_id: targetId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User banned successfully!');
                window.location.reload();
            } else {
                alert('Failed to ban user.');
            }
        })
}

function dismissReport(reportId, targetType, targetId) {
    console.log("Report ID:", reportId);
    fetch('scripts/dismiss_report.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            report_id: reportId,
            target_type: targetType,
            target_id: targetId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Report dismissed successfully!');
                window.location.reload();
            } else {
                alert('Failed to dismiss report.');
            }
        })
}

function deleteTarget(targetType, targetId, reportId) {
    fetch('scripts/delete_target.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            target_type: targetType,
            target_id: targetId,
            report_id: reportId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${targetType === 'message' ? 'Conversation' : 'Review'} deleted successfully!`);
                window.location.reload();
            } else {
                alert(`Failed to delete ${targetType === 'message' ? 'Conversation' : 'Review'}.`);
            }
        })
}

function openUserDetailsModal(bannedUser) {
    console.log(bannedUser);
    fetch('scripts/fetch_user_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: bannedUser.banned_user_id
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            console.log(data.user_data);
            if (data.error) {
                alert('Failed to fetch user data.');
            } else {
                const userDetails = data.user_data;
                document.getElementById('banned-user-modal-user-id').innerText = userDetails.id;
                document.getElementById('banned-user-modal-user-name').innerText = userDetails.first_name + " " + userDetails.last_name;
                document.getElementById('banned-user-modal-user-type').innerText = userDetails.user_type;
                document.getElementById('banned-user-modal-ban-reason').innerText = bannedUser.ban_reason;

                const modal = new bootstrap.Modal(document.getElementById('banned-user-details-modal'));
                modal.show();
            }
        })


}

function openUnbanUserModal(bannedUser) {

    console.log(bannedUser);


    const footerActions = document.getElementById('unban-user-modal-footer-actions');
    footerActions.innerHTML = "";

    const unbanUserButton = `<button class="btn btn-secondary" onclick="unbanUser(${bannedUser.banned_user_id})">Unban user</button>`;
    footerActions.innerHTML = unbanUserButton;

    const modal = new bootstrap.Modal(document.getElementById('unban-user-modal'));
    modal.show();
}

function unbanUser(userId) {
    fetch('scripts/unban_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId
        })

    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User unbanned successfully!');
                window.location.reload();
            } else {
                alert('Failed to unban user.');
            }
        })
}

function openReportDetailsModal(report, adminId) {
    fetch('scripts/check_if_user_is_already_banned.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: report.reported_id
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.user_is_banned) {
                console.log("User is already banned.");
            } else {
                console.log("User is not banned.");
            }
            console.log(report);
            document.getElementById("report-details-modal-report-id").innerText = report.id;
            document.getElementById("report-details-modal-reported-user-id").innerText = report.reported_id;
            document.getElementById("report-details-modal-report-type").innerText = report.target_type;
            document.getElementById("report-details-modal-report-content").innerText = report.target_content;
            document.getElementById("report-details-modal-report-reason").innerText = report.reason;

            if (data.user_is_banned) {
                document.getElementById("report-details-modal-user-is-already-banned-warning").style.display = "block";
            } else {
                document.getElementById("report-details-modal-user-is-already-banned-warning").style.display = "none";
            }

            const footerActions = document.getElementById("modal-footer-actions");
            footerActions.innerHTML = ""; // Clear previous actions

            if (report.status === 'pending') {
                const deleteUserButton = `<button class="btn btn-secondary" onClick="deleteUser(${report.reported_id}, ${report.id})">Delete user</button>`

                let banUserButton = "";
                if (!data.user_is_banned) {
                    banUserButton = `<button class="btn btn-secondary" onclick="banUser(${report.reported_id}, ${adminId}, '${report.reason}', ${report.id}, '${report.target_type}', ${report.target_id})">Ban user</button>`;
                }
                const deleteTargetButton = `<button class="btn btn-secondary" onclick="deleteTarget('${report.target_type}', ${report.target_id}, ${report.id})">Delete ${report.target_type === 'message' ? 'conversation' : 'review'}</button>`;
                const dismissButton = `<button class="btn btn-secondary" onclick="dismissReport(${report.id}, '${report.target_type}', ${report.target_id})">Dismiss</button>`;
                footerActions.innerHTML = deleteUserButton + banUserButton + deleteTargetButton + dismissButton;

            }

            const modal = new bootstrap.Modal(document.getElementById('reportDetailsModal'));
            modal.show(); // <- this opens it
        })
}