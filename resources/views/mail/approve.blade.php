<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Project Status Update</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, sans-serif;">

    ```
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:20px;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg, #1e293b, #334155); padding:20px; text-align:center;">
                            <h2 style="color:#ffffff; margin:0;">Project Update</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333;">

                            <p style="font-size:16px; margin-bottom:20px;">
                                Hello,
                            </p>

                            <p style="font-size:15px; line-height:1.6;">
                                Your project <strong style="color:#0f172a;">{{ $data->project->title }}</strong>
                                has been updated.
                            </p>

                            <!-- Info Box -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="margin:20px 0; border:1px solid #e5e7eb; border-radius:6px;">

                                <tr>
                                    <td style="background:#f9fafb; font-weight:bold;">Project Name</td>
                                    <td>{{ $data->project->title }}</td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb; font-weight:bold;">Status</td>
                                    <td>
                                        <span style="
                                        padding:5px 10px;
                                        border-radius:5px;
                                        color:#fff;
                                        font-size:13px;
                                        background-color:
                                            @if($data->status == '1') #16a34a
                                            @elseif($data->status == '2') #dc2626
                                            @else #f59e0b
                                            @endif;
                                    ">
                                            @if($data->status == '1') Approved
                                            @elseif($data->status == '2') Rejected
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="background:#f9fafb; font-weight:bold;">Updated At</td>
                                    <td>{{ $data->updated_at->format('d-m-Y') }}</td>
                                </tr>

                            </table>

                            <p style="font-size:14px; color:#555;">
                                If you have any questions, feel free to contact our support team.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f5f9; text-align:center; padding:15px; font-size:12px; color:#64748b;">
                            © {{ date('Y') }} Your Company. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
    ```

</body>

</html>