<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'name' => 'How can I get a Demo ID to try out the games?',
            'description' => "Simply navigate to the 'Get Demo ID'section in the app's home menu. From there, explore the list of platforms offering demo IDs for various games. Tap on your preferred platform to access the demo ID and start exploring the games.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '2',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => 'How do I obtain a Live ID to play games?',
            'description' => "To get a Live ID for playing games, go to the 'Get ID' section in the app's home menu. You'll find a list of platforms providing live IDs for different games. Select your desired platform to access the live ID and begin playing.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '3',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => ' How do I create an account on Sprinters Online?',
            'description' => "To create an account, simply tap on the 'Sign up' option on the login screen and follow the prompts to enter your name, email, and password.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '4',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "I'm having trouble logging into my account. What should I do?",
            'description' => "Please ensure that you're entering the correct email address and password. If you've forgotten your password, you can tap on the 'Forgot Password' option to reset it.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '4',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "Why is the app running slow on my device?",
            'description' => "The app's performance may vary based on your device's specifications and network connectivity. Try closing other background apps and ensuring a stable internet connection for optimal performance.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '5',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "How can I report app crashes or technical issues?",
            'description' => "If you encounter any app crashes or technical issues, please provide details about the problem, including when it occurred and any error messages received. You can then submit a report through the 'Feedback' section in the app settings.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '5',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "How do I update the app to the latest version?",
            'description' => "You can update the app to the latest version from the Google Play Store (for Android devices) or the App Store (for iOS devices). Simply search for 'Sprinters Online' and tap on the 'Update' button if an update is available",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '6',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => " Can I access customer support directly from the app?",
            'description' => "Yes, you can access customer support directly from the app by tapping on the 'Support' or 'Help' option in the menu. You can then choose to contact us via live chat, email, or phone for assistance.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '6',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "How can I change my account password?",
            'description' => "To change your account password, go to the 'Profile' section in the app settings and select the 'Change Password' option. Follow the prompts to enter your current password and set a new one.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '7',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "Is it possible to delete my account?",
            'description' => "Yes, you can delete your account by contacting customer support. Please note that this action is irreversible and will permanently remove all your account data.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '7',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "How does Sprinters Online protect my personal information?",
            'description' => "Sprinters Online takes user privacy and security seriously. We use encryption and secure protocols to safeguard your personal information. Additionally, we adhere to strict privacy policies to ensure the confidentiality of your data.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '8',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "Can I customize my privacy settings within the app?",
            'description' => "Yes, you can customize your privacy settings within the app by accessing the 'Privacy Settings' section in the settings menu. Here, you can manage your data sharing preferences and privacy controls.",
            'status' => 'Active',
            'type_id' => '2',
            'category_id' => '8',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "The app is working very slow on my device.",
            'status' => 'Active',
            'type_id' => '1',
            'category_id' => '1',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "I encountered difficulties logging in",
            'status' => 'Active',
            'type_id' => '1',
            'category_id' => '1',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "The app crashes frequently during usage.",
            'status' => 'Active',
            'type_id' => '1',
            'category_id' => '1',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "Certain features or functionalities are not working as expected.",
            'status' => 'Active',
            'type_id' => '1',
            'category_id' => '1',
            'created_by' => 1,
        ]);
        Faq::create([
            'name' => "I'm experiencing issues with in-app purchases or transactions.",
            'status' => 'Active',
            'type_id' => '1',
            'category_id' => '1',
            'created_by' => 1,
        ]);
    }
}
