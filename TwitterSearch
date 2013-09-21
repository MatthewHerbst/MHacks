import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;

import twitter4j.*;
import twitter4j.conf.ConfigurationBuilder;

public class TwitterSearch {
	static File file = new File("Job_File.txt");
	static FileOutputStream fop;
	@SuppressWarnings("deprecation")
	public static void main(String args[]) throws TwitterException, IOException{ 
		ConfigurationBuilder cb = new ConfigurationBuilder();
		cb.setDebugEnabled(true)
		  .setOAuthConsumerKey("jO65HushV2dafMJO0QBThg")
		  .setOAuthConsumerSecret("HKW2wpBk9OAWqdyBQf7EiskaE2fKTIW2LMSzHbvyf0A")
		  .setOAuthAccessToken("86713295-US8uFcPqZyDwpou2BfweigN3dCcl1rO3L0tBM8vQ8")
		  .setOAuthAccessTokenSecret("Wfgy2MEnO4r3ymMw9uYtA8myqcUW5kwWeMmwVRiqs");
		TwitterStreamFactory tf = new TwitterStreamFactory(cb.build());
		//TwitterStream twitterStream = new TwitterStreamFactory().getInstance();
		TwitterStream twitterStream = tf.getInstance();
		StatusListener listener = new StatusListener() {
            @Override
            public void onStatus(Status status) {
            	System.out.println("@" + status.getUser().getLocation() + " - " + status.getText() + "Date" + status.getCreatedAt() + ",");
            	String temp = "@" + status.getUser().getScreenName() + " - " + status.getText() + "Date" + status.getCreatedAt();
            	try {
					AddToFile(temp);
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
            }
			@Override
            public void onDeletionNotice(StatusDeletionNotice statusDeletionNotice) {
                System.out.println("Got a status deletion notice id:" + statusDeletionNotice.getStatusId());
            }

            @Override
            public void onTrackLimitationNotice(int numberOfLimitedStatuses) {
                System.out.println("Got track limitation notice:" + numberOfLimitedStatuses);
            }

            @Override
            public void onScrubGeo(long userId, long upToStatusId) {
                System.out.println("Got scrub_geo event userId:" + userId + " upToStatusId:" + upToStatusId);
            }

            @Override
            public void onStallWarning(StallWarning warning) {
                System.out.println("Got stall warning:" + warning);
            }

            @Override
            public void onException(Exception ex) {
                ex.printStackTrace();
            }
        };
        twitterStream.addListener(listener);
        FilterQuery fq = new FilterQuery();
        String keywords[] = {"Software","Big Data","#Hiring","#job","Business Analyst"};
        fq.track(keywords);
        twitterStream.filter(fq);
    }
	
	  private static void AddToFile(String temp) throws IOException {
		  try {
			    PrintWriter out = new PrintWriter(new BufferedWriter(new FileWriter("Job_File.txt", true)));
			    out.println(temp);
			    out.close();
			} catch (IOException e) {
			    //oh noes!
			}		
		}
}
