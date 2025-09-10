<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Testimony Submission - WCI Newport</title>
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
            border-left: 4px solid #e74c3c;
            margin-bottom: 25px;
        }
        .testimony-details {
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
            width: 120px;
            color: #e74c3c;
        }
        .detail-value {
            flex: 1;
        }
        .testimony-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 25px;
        }
        .testimony-content h3 {
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
        .badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.pending {
            background-color: #ffc107;
            color: #212529;
        }
        .engagement-list {
            margin: 0;
            padding-left: 20px;
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
        <!-- Header -->
        <div class="header">
            <h1>WCI Newport</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="message-header">
                <h2 style="margin: 0; color: #333;">New Testimony Submission</h2>
                <p style="margin: 5px 0 0 0; color: #6c757d;">A new testimony has been submitted and is awaiting your review.</p>
            </div>

            <!-- Testimony Details -->
            <div class="testimony-details">
                <h3 style="margin-top: 0; color: #e74c3c;">Testimony Information</h3>

                <div class="detail-row">
                    <div class="detail-label">Title:</div>
                    <div class="detail-value"><strong>{{ $testimonyData['title'] }}</strong></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Author:</div>
                    <div class="detail-value">{{ $testimonyData['author'] }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $testimonyData['email'] }}" style="color: #e74c3c;">{{ $testimonyData['email'] }}</a>
                    </div>
                </div>

                @if(!empty($testimonyData['phone']))
                <div class="detail-row">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value">
                        <a href="tel:{{ $testimonyData['phone'] }}" style="color: #e74c3c;">{{ $testimonyData['phone'] }}</a>
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">Category:</div>
                    <div class="detail-value"><span class="badge">{{ $testimonyData['result_category'] }}</span></div>
                </div>

                @if(!empty($testimonyData['testimony_date']))
                <div class="detail-row">
                    <div class="detail-label">Date of Testimony:</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($testimonyData['testimony_date'])->format('M j, Y') }}</div>
                </div>
                @endif

                @if(!empty($testimonyData['engagements']) && count($testimonyData['engagements']) > 0)
                <div class="detail-row">
                    <div class="detail-label">Engagements:</div>
                    <div class="detail-value">
                        <ul class="engagement-list">
                            @foreach($testimonyData['engagements'] as $engagement)
                                <li>{{ $engagement }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value"><span class="badge pending">{{ ucfirst($testimonyData['status']) }}</span></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Publish Permission:</div>
                    <div class="detail-value">{{ $testimonyData['publish_permission'] ? 'Yes' : 'No' }}</div>
                </div>
            </div>

            <!-- Testimony Content -->
            <div class="testimony-content">
                <h3>Testimony:</h3>
                <p style="margin: 0; white-space: pre-line;">{{ $testimonyData['content'] }}</p>
            </div>

            <!-- Action Buttons -->
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/admin/testimonies" class="btn">Review in Admin Panel</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This testimony was submitted through the WCI Newport website on {{ $testimonyData['submitted_at']->format('M j, Y \a\t g:i A') }}.</p>
            <p>&copy; {{ date('Y') }} WCI Newport. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
