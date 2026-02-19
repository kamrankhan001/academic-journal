<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Review Invitation</title>
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
          <td style="background: #86662c; padding: 32px 30px; text-align: center; border-radius: 16px 16px 0 0; color: #ffffff; font-size: 26px; font-weight: 700; letter-spacing: -0.02em; border-bottom: 1px solid #6b4f23;" bgcolor="#86662c">
            Review Invitation
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
              
              <!-- Author -->
              <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb; font-size: 16px;">
                  <strong style="color: #4b5563;">Author:</strong> <span style="color: #111827; font-weight: 500;">{{ $assignment->journal->author->name }}</span>
                </td>
              </tr>
              
              <!-- Due Date -->
              <tr>
                <td style="padding: 12px 0; font-size: 16px;">
                  <strong style="color: #4b5563;">Due Date:</strong> 
                  <span style="color: #111827; font-weight: 500;">{{ $assignment->due_date->format('F j, Y') }}</span>
                </td>
              </tr>
            </table>
            
            <!-- Divider -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
              <tr>
                <td style="height: 1px; background: #e5e7eb; font-size: 0; line-height: 0;" bgcolor="#e5e7eb">&nbsp;</td>
              </tr>
            </table>
            
            <!-- Invitation Message -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 20px;">
              <tr>
                <td style="font-size: 18px; color: #86662c; font-weight: 600; padding-bottom: 15px;">
                  📋 You've Been Invited to Review
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 15px;">
                  You have been selected to review the manuscript "<strong>{{ $assignment->journal->title }}</strong>" based on your expertise in this field.
                </td>
              </tr>
              
              @if($assignment->notes)
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 15px; background: #f9fafb; padding: 15px; border-radius: 8px; border-left: 4px solid #86662c;">
                  <strong style="color: #4b5563;">Message from Editor:</strong><br>
                  {{ $assignment->notes }}
                </td>
              </tr>
              @endif
              
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6;">
                  Please respond to this invitation by accepting or declining. If accepted, you will have until <strong>{{ $assignment->due_date->format('F j, Y') }}</strong> to complete your review.
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
                        <a href="{{ route('reviewer.assignments.show', $assignment->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">View Invitation</a>
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
                  Thank you for contributing to our peer review process!
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