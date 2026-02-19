<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Review Reminder</title>
</head>
<body style="margin: 0; padding: 20px; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1f2937;">

<!-- Main Container -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f3f4f6;">
  <tr>
    <td align="center" style="padding: 20px;">
      
      <!-- Card -->
      <table width="560" cellpadding="0" cellspacing="0" border="0" style="max-width: 560px; width: 100%; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; border-collapse: separate; mso-table-lspace: 0; mso-table-rspace: 0;">
        
        <!-- Header -->
        <tr>
          <td style="background: {{ $assignment->due_date->isPast() ? '#dc2626' : '#86662c' }}; padding: 32px 30px; text-align: center; border-radius: 16px 16px 0 0; color: #ffffff; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; border-bottom: 1px solid {{ $assignment->due_date->isPast() ? '#b91c1c' : '#6b4f23' }};" bgcolor="{{ $assignment->due_date->isPast() ? '#dc2626' : '#86662c' }}">
            {{ $assignment->due_date->isPast() ? '⚠️ Review Overdue' : '📋 Review Reminder' }}
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
                  <strong style="color: #4b5563;">Dear:</strong> <span style="color: #111827; font-weight: 500;">{{ $assignment->reviewer->user->name }}</span>
                </td>
              </tr>
              
              <!-- Journal Title -->
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; font-size: 16px;">
                  <strong style="color: #4b5563;">Journal Title:</strong> <span style="color: #111827; font-weight: 500;">{{ $assignment->journal->title }}</span>
                </td>
              </tr>
              
              <!-- Due Date -->
              <tr>
                <td style="padding: 12px 0; font-size: 16px;">
                  <strong style="color: #4b5563;">Due Date:</strong> 
                  <span style="color: {{ $assignment->due_date->isPast() ? '#dc2626' : '#111827' }}; font-weight: 600;">{{ $assignment->due_date->format('F j, Y') }}</span>
                  @if($assignment->due_date->isPast())
                    <span style="color: #dc2626; font-weight: 600; margin-left: 10px;">(Overdue)</span>
                  @endif
                </td>
              </tr>
            </table>
            
            <!-- Divider -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
              <tr>
                <td style="height: 1px; background: #e5e7eb; font-size: 0; line-height: 0;" bgcolor="#e5e7eb">&nbsp;</td>
              </tr>
            </table>
            
            <!-- Reminder Message -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 20px;">
              <tr>
                <td style="font-size: 18px; color: {{ $assignment->due_date->isPast() ? '#dc2626' : '#86662c' }}; font-weight: 600; padding-bottom: 15px;">
                  @if($assignment->due_date->isPast())
                    ⚠️ Your Review is Overdue
                  @else
                    ⏰ Friendly Reminder
                  @endif
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 15px;">
                  @if($assignment->due_date->isPast())
                    Your review for "<strong>{{ $assignment->journal->title }}</strong>" was due on <strong>{{ $assignment->due_date->format('F j, Y') }}</strong>. Please complete it as soon as possible.
                  @else
                    This is a reminder that your review for "<strong>{{ $assignment->journal->title }}</strong>" is due on <strong>{{ $assignment->due_date->format('F j, Y') }}</strong>.
                  @endif
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6;">
                  Your timely review helps us maintain our publication schedule and provides valuable feedback to authors.
                </td>
              </tr>
            </table>
            
            <!-- Button Container -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 35px 0 20px;">
              <tr>
                <td align="center">
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table;">
                    <tr>
                      <td style="background-color: #86662c; padding: 14px 32px; border-radius: 8px; border: 1px solid #6b4f23;" bgcolor="#86662c">
                        <a href="{{ route('reviewer.assignments.review', $assignment->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">Complete Review Now</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <!-- Footer Note -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
              <tr>
                <td align="center" style="color: #6b7280; font-size: 14px;">
                  Thank you for your valuable contribution to our peer review process!
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