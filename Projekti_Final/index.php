<?php
// --- Configuration & Mock Data ---
$user = [
    'name' => 'John Citizen',
    'role' => 'Citizen',
    'isAdmin' => false // Change to true to see Admin Tools
];

$stats = [
    'total'    => ['count' => '1,248', 'trend' => '+12.5%', 'trendUp' => true],
    'pending'  => ['count' => '328',   'trend' => '+5.2%',  'trendUp' => false],
    'review'   => ['count' => '156',   'trend' => '+8.3%',  'trendUp' => true],
    'resolved' => ['count' => '764',   'trend' => '+15.7%', 'trendUp' => true],
];

$reports = [
    [
        'id' => 'REP-2023-00456',
        'status' => 'pending',
        'status_label' => 'Pending',
        'title' => 'Broken Street Light on Main St',
        'date' => 'June 12, 2023',
        'desc' => 'The street light near the intersection of Main St and 5th Ave has been out for 3 days.',
        'district' => 'District 5',
        'category' => 'Infrastructure',
        'image' => 'https://images.unsplash.com/photo-1516054575922-f0b8eeadec1a?auto=format&fit=crop&w=1470&q=80'
    ],
    [
        'id' => 'REP-2023-00455',
        'status' => 'review',
        'status_label' => 'Under Review',
        'title' => 'Illegal Dumping in Alleyway',
        'date' => 'June 11, 2023',
        'desc' => 'Someone has been dumping construction debris in the alley behind 123 Maple Street.',
        'district' => 'District 3',
        'category' => 'Pollution',
        'image' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=1374&q=80'
    ]
];

// Helper function for status colors
function getStatusClass($status) {
    return match($status) {
        'pending'  => 'status-pending',
        'review'   => 'status-review',
        'resolved' => 'status-resolved',
        default    => 'bg-gray-500'
    };
}

// Handle Form Submission (Simple Logic)
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['reportTitle']);
    $message = "Report '$title' submitted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityWatch - <?= $user['name'] ?> Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #2563eb; --secondary: #1e40af; --accent: #3b82f6; --dark: #1e293b; --light: #f8fafc; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; }
        .sidebar { transition: all 0.3s ease; }
        .status-pending { background-color: #f59e0b; }
        .status-review { background-color: #3b82f6; }
        .status-resolved { background-color: #10b981; }
        .map-container { height: 400px; background-color: #e2e8f0; border-radius: 0.5rem; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); position: fixed; z-index: 50; height: 100vh; } .sidebar.active { transform: translateX(0); } }
    </style>
</head>
<body class="min-h-screen">

    <div id="sidebar" class="sidebar w-64 bg-white shadow-lg fixed h-full">
        <div class="p-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-city mr-2"></i> CityWatch
            </h1>
            <p class="text-sm text-gray-500">Smart Reporting Platform</p>
        </div>
        
        <div class="p-4">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div>
                    <p class="font-medium"><?= $user['name'] ?></p>
                    <p class="text-xs text-gray-500"><?= $user['role'] ?></p>
                </div>
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li><a href="#" class="flex items-center space-x-3 p-2 rounded-lg bg-blue-50 text-blue-600"><i class="fas fa-home w-5"></i><span>Dashboard</span></a></li>
                    <li><button onclick="toggleModal()" class="w-full flex items-center space-x-3 p-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 text-gray-700"><i class="fas fa-plus-circle w-5"></i><span>New Report</span></button></li>
                    
                    <?php if($user['isAdmin']): ?>
                    <li id="adminSection">
                        <div class="mt-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin Tools</div>
                        <ul class="space-y-2 ml-2">
                            <li><a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-blue-50 text-gray-700"><i class="fas fa-tasks w-5"></i><span>Manage Reports</span></a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <div class="md:ml-64">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Dashboard Overview</h2>
                <?php if($message): ?>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm"><?= $message ?></span>
                <?php endif; ?>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <?php foreach($stats as $key => $data): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase"><?= $key ?></p>
                            <p class="text-3xl font-semibold text-gray-900"><?= $data['count'] ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="<?= $data['trendUp'] ? 'text-green-600' : 'text-red-600' ?> text-sm font-medium"><?= $data['trend'] ?></span>
                        <span class="text-gray-500 text-sm ml-2">vs last month</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Recent Reports</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php foreach($reports as $report): ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="px-2 py-1 text-xs rounded-full <?= getStatusClass($report['status']) ?> text-white">
                                        <?= $report['status_label'] ?>
                                    </span>
                                    <span class="text-xs text-gray-500">#<?= $report['id'] ?></span>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900"><?= $report['title'] ?></h4>
                                <p class="text-sm text-gray-500">Reported on <?= $report['date'] ?></p>
                                <p class="text-sm text-gray-700 mt-2"><?= $report['desc'] ?></p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <img class="h-16 w-16 rounded-md object-cover" src="<?= $report['image'] ?>" alt="Report">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-medium">New Issue Report</h3>
                <button onclick="toggleModal()" class="text-gray-500"><i class="fas fa-times"></i></button>
            </div>
            <form class="p-6" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="reportTitle" required class="w-full px-3 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="reportDescription" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Submit Report</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            document.getElementById('reportModal').classList.toggle('hidden');
        }
    </script>
</body>
</html>