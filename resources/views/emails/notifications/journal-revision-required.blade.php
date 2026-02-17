<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Revision Required</title>
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
            Revision Required
          </td>
        </tr>
        
        <!-- Content -->
        <tr>
          <td style="padding: 40px 35px;">
            
            <!-- Field: Dear -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Dear</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->author->name }}</td>
              </tr>
            </table>
            
            <!-- Field: Journal Title -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Journal Title</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->title }}</td>
              </tr>
            </table>
            
            <!-- Field: Status -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Status</td>
              </tr>
              <tr>
                <td>
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table;">
                    <tr>
                      <td style="background-color: #86662c; padding: 6px 18px; border-radius: 30px; border: 1px solid #6b4f23; color: #ffffff; font-size: 14px; font-weight: 600;" bgcolor="#86662c">
                        Revision Required
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <!-- Divider -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 32px 0;">
              <tr>
                <td style="height: 1px; background: #e5e7eb; font-size: 0; line-height: 0;" bgcolor="#e5e7eb">&nbsp;</td>
              </tr>
            </table>
            
            @if($revision_notes)
              <!-- Reviewer Comments -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
                <tr>
                  <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Reviewer Comments</td>
                </tr>
                <tr>
                  <td style="background-color: #f9fafb; padding: 24px; border: 1px solid #e5e7eb; border-left: 4px solid #86662c; border-radius: 12px; color: #1f2937; line-height: 1.6; font-size: 16px;" bgcolor="#f9fafb">
                    {!! nl2br(e($revision_notes)) !!}
                  </td>
                </tr>
              </table>
            @else
              <!-- Info Box -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
                <tr>
                  <td style="background-color: #f9fafb; padding: 24px; border: 1px solid #e5e7eb; border-left: 4px solid #86662c; border-radius: 12px; color: #1f2937; line-height: 1.6;" bgcolor="#f9fafb">
                    Our reviewers have provided feedback that requires your attention. Please log in to your account to view the detailed reviewer comments.
                  </td>
                </tr>
              </table>
            @endif
            
            <!-- Message -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0 20px;">
              <tr>
                <td style="font-size: 17px; color: #1f2937; line-height: 1.6;">
                  Please make the necessary revisions and resubmit your journal at your earliest convenience.
                </td>
              </tr>
            </table>
            
            <!-- Button Container -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 40px 0 20px;">
              <tr>
                <td align="center">
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table; margin: 0 3px;">
                    <tr>
                      <td style="background-color: #86662c; padding: 14px 32px; border-radius: 8px; border: 1px solid #6b4f23;" bgcolor="#86662c">
                        <a href="{{ route('author.journals.edit', $journal->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">Revise Journal</a>
                      </td>
                    </tr>
                  </table>
                  
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table; margin: 0 3px;">
                    <tr>
                      <td style="background-color: #6b7280; padding: 14px 32px; border-radius: 8px; border: 1px solid #4b5563;" bgcolor="#6b7280">
                        <a href="{{ route('author.journals.show', $journal->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">View Details</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <!-- Footer Note -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 24px;">
              <tr>
                <td align="center" style="color: #6b7280; font-size: 15px;">
                  If you have any questions about the revision requirements, please don't hesitate to contact our editorial office.
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