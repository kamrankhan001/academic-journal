<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>New Journal Submission</title>
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
            New Journal Submission
          </td>
        </tr>
        
        <!-- Content -->
        <tr>
          <td style="padding: 40px 35px;">
            
            <!-- Field: From -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">From</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">
                  {{ $journal->author->name }}<br>
                  <span style="color: #6b7280; font-size: 14px;">{{ $journal->author->email }}</span>
                </td>
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
                        Pending Review
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
            
            <!-- Field: Abstract -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Abstract</td>
              </tr>
              <tr>
                <td style="background-color: #f9fafb; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; color: #1f2937; line-height: 1.5; font-size: 16px;" bgcolor="#f9fafb">
                  {{ Str::limit($journal->abstract, 200) }}
                </td>
              </tr>
            </table>
            
            <!-- Field: Tags -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Tags</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->tags->pluck('name')->join(', ') ?: 'None' }}</td>
              </tr>
            </table>
            
            <!-- Field: Files -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Files</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->files->count() }} file(s) attached</td>
              </tr>
            </table>
            
            <!-- Field: Submitted -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Submitted</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->created_at->format('F j, Y \a\t g:i A') }}</td>
              </tr>
            </table>
            
            <!-- Button Container -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 35px 0 20px;">
              <tr>
                <td align="center">
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table;">
                    <tr>
                      <td style="background-color: #86662c; padding: 14px 32px; border-radius: 8px; border: 1px solid #6b4f23;" bgcolor="#86662c">
                        <a href="{{ route('admin.journals.show', $journal->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">Review Submission</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <!-- Footer Note -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
              <tr>
                <td align="center" style="color: #6b7280; font-size: 15px; padding-top: 10px;">
                  Thank you for your submission. You will be notified once the review process begins.
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