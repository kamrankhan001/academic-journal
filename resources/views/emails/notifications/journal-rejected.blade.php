<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Journal Submission Update</title>
</head>
<body style="margin: 0; padding: 20px; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1f2937;">

<!-- Main Container -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f3f4f6;">
  <tr>
    <td align="center" style="padding: 20px;">
      
      <!-- Card -->
      <table width="560" cellpadding="0" cellspacing="0" border="0" style="max-width: 560px; width: 100%; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; border-collapse: separate; mso-table-lspace: 0; mso-table-rspace: 0;">
        
        <!-- Header - Keeping Red for Rejection -->
        <tr>
          <td style="background: #dc2626; padding: 32px 30px; text-align: center; border-radius: 16px 16px 0 0; color: #ffffff; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; border-bottom: 1px solid #b91c1c;" bgcolor="#dc2626">
            Journal Submission Update
          </td>
        </tr>
        
        <!-- Content -->
        <tr>
          <td style="padding: 40px 35px;">
            
            <!-- Info Table -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 25px;">
              
              <!-- Dear -->
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; font-size: 16px;">
                  <strong style="color: #4b5563;">Dear:</strong> <span style="color: #111827; font-weight: 500;">{{ $journal->author->name }}</span>
                </td>
              </tr>
              
              <!-- Journal Title -->
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; font-size: 16px;">
                  <strong style="color: #4b5563;">Journal Title:</strong> <span style="color: #111827; font-weight: 500;">{{ $journal->title }}</span>
                </td>
              </tr>
              
              <!-- Status with Badge -->
              <tr>
                <td style="padding: 12px 0; font-size: 16px;">
                  <strong style="color: #4b5563;">Status:</strong>
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table; margin-left: 5px;">
                    <tr>
                      <td style="background-color: #dc2626; padding: 6px 14px; border-radius: 20px; color: #ffffff; font-size: 13px; font-weight: 600; border: 1px solid #b91c1c;" bgcolor="#dc2626">
                        Not Accepted
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            @if($rejection_reason)
              <!-- Comment Box -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 20px 0 25px;">
                <tr>
                  <td style="padding: 16px 20px; border-left: 4px solid #dc2626; background-color: #fee2e2; border-radius: 8px; font-size: 15px; line-height: 1.6; color: #991b1b;" bgcolor="#fee2e2">
                    {!! nl2br(e($rejection_reason)) !!}
                  </td>
                </tr>
              </table>
            @endif
            
            <!-- Divider -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
              <tr>
                <td style="height: 1px; background: #e5e7eb; font-size: 0; line-height: 0;" bgcolor="#e5e7eb">&nbsp;</td>
              </tr>
            </table>
            
            <!-- Message -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 20px;">
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 15px;">
                  Thank you for submitting your work to <strong style="color: #86662c;">{{ config('app.name') }}</strong>.
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 15px;">
                  After careful review, we regret to inform you that we cannot accept this submission for publication at this time.
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6;">
                  We appreciate the effort you have put into your research and encourage you to consider submitting other work to us in the future.
                </td>
              </tr>
            </table>
            
            <!-- Button Container (Theme Color) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 35px 0 20px;">
              <tr>
                <td align="center">
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table;">
                    <tr>
                      <td style="background-color: #86662c; padding: 14px 28px; border-radius: 8px; border: 1px solid #6b4f23;" bgcolor="#86662c">
                        <a href="{{ route('author.journals.show', $journal->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">View Submission Details</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <!-- Footer Note -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
              <tr>
                <td align="center" style="color: #6b7280; font-size: 14px; line-height: 1.5;">
                  If you have any questions about this decision, please don't hesitate to contact our editorial office.
                </td>
              </tr>
            </table>
            
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>

</body>
</html>