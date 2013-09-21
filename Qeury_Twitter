import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;

import twitter4j.Query;
import twitter4j.QueryResult;
import twitter4j.Status;
import twitter4j.StatusListener;
import twitter4j.Twitter;
import twitter4j.TwitterException;
import twitter4j.TwitterFactory;
import twitter4j.TwitterStream;
import twitter4j.TwitterStreamFactory;
import twitter4j.conf.ConfigurationBuilder;


public class Query_Twitter {
	public static void main(String args[]) throws TwitterException, IOException{
		  ConfigurationBuilder cb = new ConfigurationBuilder();
			cb.setDebugEnabled(true)
			  .setOAuthConsumerKey("jO65HushV2dafMJO0QBThg")
			  .setOAuthConsumerSecret("HKW2wpBk9OAWqdyBQf7EiskaE2fKTIW2LMSzHbvyf0A")
			  .setOAuthAccessToken("86713295-US8uFcPqZyDwpou2BfweigN3dCcl1rO3L0tBM8vQ8")
			  .setOAuthAccessTokenSecret("Wfgy2MEnO4r3ymMw9uYtA8myqcUW5kwWeMmwVRiqs");
		    Query query = new Query("nexus");
		    @SuppressWarnings("static-access")
			Twitter twitter = new TwitterFactory(cb.build()).getInstance();
		    query.setCount(100000);
		    QueryResult result = twitter.search(query);
		    for (Status status : result.getTweets()) {
		        System.out.println("@" + status.getUser().getScreenName() + ":" + status.getText());
		    }
		
}
}
