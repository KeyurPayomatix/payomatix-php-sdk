<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payomatix SDK V2 API Examples</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .example-link {
            display: block;
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s ease;
        }
        .example-link:hover {
            background: #e9ecef;
            border-color: #007bff;
            color: #007bff;
            transform: translateY(-2px);
        }
        .description {
            color: #6c757d;
            font-size: 14px;
            margin-top: 5px;
        }
        .version-badge {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            Payomatix SDK V2 API Examples 
            <span class="version-badge">V2</span>
        </h1>
        
        <p>Welcome to the Payomatix SDK V2 API examples. These examples demonstrate how to use the new V2 endpoints for enhanced functionality and improved performance.</p>
        
        <h2>Available Examples:</h2>
        
        <a href="hosted-example.php" class="example-link">
            <strong>Hosted Payment Example</strong>
            <div class="description">
                Demonstrates how to integrate Payomatix's Hosted Payment Page using V2 API endpoints.
                This example shows how to redirect customers to a hosted payment page.
            </div>
        </a>
        
        <a href="seamless-example.php" class="example-link">
            <strong>Seamless Payment Example</strong>
            <div class="description">
                Demonstrates how to process payments directly through the API using V2 endpoints.
                This example shows how to handle card payments without redirecting customers.
            </div>
        </a>
        
        <a href="transaction-status-example.php" class="example-link">
            <strong>Transaction Status Example</strong>
            <div class="description">
                Demonstrates how to check the status of a transaction using V2 API endpoints.
                This example shows how to verify payment status after processing.
            </div>
        </a>
        
        <div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 5px; border-left: 4px solid #007bff;">
            <strong>Note:</strong> Before running these examples, make sure to:
            <ul>
                <li>Replace <code>YOUR-PAYOMATIX-SECRET-KEY</code> with your actual API key</li>
                <li>Update the return URLs and webhook URLs to point to your actual endpoints</li>
                <li>Install dependencies using <code>composer install payomatix/payomatix-sdk</code></li>
            </ul>
        </div>
    </div>
</body>
</html> 