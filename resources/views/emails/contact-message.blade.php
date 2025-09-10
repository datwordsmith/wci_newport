
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - WCI Newport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 30px 20px;
        }
        .message-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #989898;
            margin-bottom: 25px;
        }
        .contact-details {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            width: 80px;
            color: #e74c3c;
        }
        .detail-value {
            flex: 1;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 25px;
        }
        .message-content h3 {
            margin-top: 0;
            color: #e74c3c;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                box-shadow: none;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="header">
            <img src="{{ asset('assets/images/lfww_logo.png') }}" alt="WCI Newport Logo">
            <h1>WCI Newport</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="message-header">
                <h2 style="margin: 0; color: #333;">New Contact Message Received</h2>
                <p style="margin: 5px 0 0 0; color: #6c757d;">You have received a new contact form submission through the church website.</p>
            </div>

            <!-- Contact Details -->
            <div class="contact-details">
                <h3 style="margin-top: 0; color: #e74c3c;">Contact Information</h3>

                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value">{{ $contactData['name'] }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $contactData['email'] }}" style="color: #e74c3c;">{{ $contactData['email'] }}</a>
                    </div>
                </div>

                @if(!empty($contactData['phone']))
                <div class="detail-row">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value">
                        <a href="tel:{{ $contactData['phone'] }}" style="color: #e74c3c;">{{ $contactData['phone'] }}</a>
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">Category:</div>
                    <div class="detail-value">{{ $contactData['category'] }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Subject:</div>
                    <div class="detail-value"><strong>{{ $contactData['subject'] }}</strong></div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="message-content">
                <h3>Message:</h3>
                <p style="margin: 0; white-space: pre-line;">{{ $contactData['message'] }}</p>
            </div>

            <!-- Action Button -->
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/admin" class="btn text-white">Admin Portal</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This message was sent through the contact form on the WCI Newport website.</p>
            <p>&copy; {{ date('Y') }} WCI Newport. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
