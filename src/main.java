import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintWriter;
import java.net.URL;
import java.net.URLConnection;
import java.util.Properties;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

import org.apache.commons.net.ftp.FTP;
import org.apache.commons.net.ftp.FTPClient;


public class main {
	
	public static void main(String args[]) throws InterruptedException, IOException{
		String skam = load("http://skam.p3.no");
		int index = skam.indexOf("post-1");
		skam = (skam.substring(index+5, index+9));
		while(true){
			try {
				String temp = load("http://skam.p3.no");
				int tempindex = temp.indexOf("post-1");
				temp = (temp.substring(tempindex+5, tempindex+9));
				System.out.println(skam + " " + temp);
				if(!temp.equals(skam)){
	//				load("http://maconsulting.no/skam/nyskam.php?navn=" + skam);
					update(skam);
					System.out.println("Ny");
					
					skam = temp;
					System.out.println(skam);
	//				sendMail();
				}
			} catch (IOException e) {
				e.printStackTrace();
			}
			
				
			Thread.sleep(10000);
		}
	}

	
	public static String load(String inp) throws IOException{
		URL url = new URL(inp);
		URLConnection spoof = url.openConnection();

		//Spoof the connection so we look like a web browser
		spoof.setRequestProperty( "User-Agent", "Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0;    H010818)" );
		BufferedReader in = new BufferedReader(new InputStreamReader(spoof.getInputStream()));
		String strLine = "";
		String finalHTML = "";
		//Loop through every line in the source
		while ((strLine = in.readLine()) != null){
		   finalHTML += strLine;
		}
		return finalHTML;
	}
	 
	public static void sendMail(){
		try {
			String to = load("http://maconsulting.no/skam/mottakere.php");
			to = to.substring(0,  to.length()-1);
			send(to, "Hola! \n\nNå er det kommet noe nytt på skam! Løp og sjekk!");
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
	
	

	public static void send(String to, String body) {

		final String username = "thomlmath@gmail.com";
		final String password = "Password";

		Properties props = new Properties();
		props.put("mail.smtp.auth", "true");
		props.put("mail.smtp.starttls.enable", "true");
		props.put("mail.smtp.host", "smtp.gmail.com");
		props.put("mail.smtp.port", "587");

		Session session = Session.getInstance(props,
		  new javax.mail.Authenticator() {
			protected PasswordAuthentication getPasswordAuthentication() {
				return new PasswordAuthentication(username, password);
			}
		  });

		try {

			Message message = new MimeMessage(session);
			message.setFrom(new InternetAddress("Skam Alert! <thomlmath@gmail.com>"));
			
			message.addRecipients(Message.RecipientType.BCC, InternetAddress.parse(to));
			
			
			message.setSubject("Skam Alert!");
			message.setText(body);

			Transport.send(message);

			System.out.println("Done");

		} catch (MessagingException e) {
			throw new RuntimeException(e);
		}
	}
	
	
	
	 public static void update(String text) {
	        String server = "f12-preview.awardspace.net";
	        int port = 21;
	        String user = "2063195";
	        String pass = "d1n0saur";
	 
	        FTPClient ftpClient = new FTPClient();
	        try {
	 
	            ftpClient.connect(server, port);
	            ftpClient.login(user, pass);
	            ftpClient.enterLocalPassiveMode();
	 
	            ftpClient.setFileType(FTP.BINARY_FILE_TYPE);
	 
	            //Make file
	            PrintWriter writer = new PrintWriter("sjekk.html", "UTF-8");
	            writer.println(text);
	            writer.close();

	            
	            
	            // APPROACH #1: uploads first file using an InputStream
	            File firstLocalFile = new File("sjekk.html");
	 
	            String firstRemoteFile = "maconsulting.no/skam/sjekk.html";
	            InputStream inputStream = new FileInputStream(firstLocalFile);
	 
	            System.out.println("Start uploading first file");
	            boolean done = ftpClient.storeFile(firstRemoteFile, inputStream);
	            inputStream.close();
	            if (done) {
	                System.out.println("The first file is uploaded successfully.");
	            }
	 /*
	            // APPROACH #2: uploads second file using an OutputStream
	            File secondLocalFile = new File("sjekk.html");
	            String secondRemoteFile = "/maconsulting.no/skam/sjekk.html";
	            InputStream inputStream = new FileInputStream(secondLocalFile);
	 
	            System.out.println("Start uploading second file");
	            OutputStream outputStream = ftpClient.storeFileStream(secondRemoteFile);
	            byte[] bytesIn = new byte[4096];
	            int read = 0;
	 
	            while ((read = inputStream.read(bytesIn)) != -1) {
	                outputStream.write(bytesIn, 0, read);
	            }
	            inputStream.close();
	            outputStream.close();
	 
	            boolean completed = ftpClient.completePendingCommand();
	            if (completed) {
	                System.out.println("The second file is uploaded successfully.");
	            }
	 */
	        } catch (IOException ex) {
	            System.out.println("Error: " + ex.getMessage());
	            ex.printStackTrace();
	        } finally {
	            try {
	                if (ftpClient.isConnected()) {
	                    ftpClient.logout();
	                    ftpClient.disconnect();
	                }
	            } catch (IOException ex) {
	                ex.printStackTrace();
	            }
	        }
	    }
	
}
