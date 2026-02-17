<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Journal Under Review</title>
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
            Journal Under Review
          </td>
        </tr>
        
        <!-- Content -->
        <tr>
          <td style="padding: 40px 35px;">
            
            <!-- Greeting -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 17px; color: #1f2937; line-height: 1.6;">
                  Dear <strong style="color: #86662c;">{{ $journal->author->name }}</strong>,
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
            
            <!-- Field: Submitted on -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
              <tr>
                <td style="font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; padding-bottom: 8px;">Submitted on</td>
              </tr>
              <tr>
                <td style="font-size: 17px; color: #111827; font-weight: 500; line-height: 1.5;">{{ $journal->created_at->format('F j, Y \a\t g:i A') }}</td>
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
                        Peer Review
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
            
            <!-- Message -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 20px;">
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6; padding-bottom: 10px;">
                  Good news! Your journal has passed the initial screening and is now under peer review.
                </td>
              </tr>
              <tr>
                <td style="font-size: 16px; color: #1f2937; line-height: 1.6;">
                  The review process typically takes <strong>2–4 weeks</strong>. Here's what happens next:
                </td>
              </tr>
            </table>
            
            <!-- Steps Box -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px;" bgcolor="#f9fafb">
              <tr>
                <td style="padding: 24px;">
                  
                  <!-- Step 1 -->
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                      <td>
                        <strong style="display: block; margin-bottom: 4px; color: #111827; font-size: 16px;">1. Reviewer Assignment</strong>
                        <span style="color: #6b7280; font-size: 15px; line-height: 1.5;">Experts are assigned to evaluate your submission.</span>
                      </td>
                    </tr>
                  </table>
                  
                  <!-- Step 2 -->
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                      <td>
                        <strong style="display: block; margin-bottom: 4px; color: #111827; font-size: 16px;">2. Review Process</strong>
                        <span style="color: #6b7280; font-size: 15px; line-height: 1.5;">Methodology, results, and conclusions are assessed.</span>
                      </td>
                    </tr>
                  </table>
                  
                  <!-- Step 3 -->
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td>
                        <strong style="display: block; margin-bottom: 4px; color: #111827; font-size: 16px;">3. Editor Decision</strong>
                        <span style="color: #6b7280; font-size: 15px; line-height: 1.5;">You will receive feedback and a final outcome.</span>
                      </td>
                    </tr>
                  </table>
                  
                </td>
              </tr>
            </table>
            
            <!-- Button Container -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 40px 0 20px;">
              <tr>
                <td align="center">
                  <table cellpadding="0" cellspacing="0" border="0" style="display: inline-table;">
                    <tr>
                      <td style="background-color: #86662c; padding: 14px 32px; border-radius: 8px; border: 1px solid #6b4f23;" bgcolor="#86662c">
                        <a href="{{ route('author.journals.show', $journal->id) }}" style="color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block;">Track Review Progress</a>
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
                  Thank you for your patience during the review process.
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