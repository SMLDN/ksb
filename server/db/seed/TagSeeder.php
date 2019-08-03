<?php

use Phinx\Seed\AbstractSeed;

class TagSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            ["name" => "Python"],
            ["name" => "JavaScript"],
            ["name" => "Ruby"],
            ["name" => "Rails"],
            ["name" => "PHP"],
            ["name" => "iOS"],
            ["name" => "AWS"],
            ["name" => "Android"],
            ["name" => "Java"],
            ["name" => "Swift"],
            ["name" => "Docker"],
            ["name" => "Linux"],
            ["name" => "Node.js"],
            ["name" => "Git"],
            ["name" => "Mac"],
            ["name" => "Unity"],
            ["name" => "C#"],
            ["name" => "Python3"],
            ["name" => "Go"],
            ["name" => "MySQL"],
            ["name" => "C++"],
            ["name" => "CSS"],
            ["name" => "Windows"],
            ["name" => "TậpTọe"],
            ["name" => "Xcode"],
            ["name" => "HTML"],
            ["name" => "Ubuntu"],
            ["name" => "CentOS"],
            ["name" => "React"],
            ["name" => "GitHub"],
            ["name" => "RaspberryPi"],
            ["name" => "Laravel"],
            ["name" => "Vue.js"],
            ["name" => "MacOSX"],
            ["name" => "Vagrant"],
            ["name" => "Objective-C"],
            ["name" => "jQuery"],
            ["name" => "Bash"],
            ["name" => "#migrated"],
            ["name" => "DeepLearning"],
            ["name" => "Vim"],
            ["name" => "TypeScript"],
            ["name" => "WordPress"],
            ["name" => "Scala"],
            ["name" => "R"],
            ["name" => "HTML5"],
            ["name" => "Kotlin"],
            ["name" => "C"],
            ["name" => "Slack"],
            ["name" => "Heroku"],
            ["name" => "nginx"],
            ["name" => "TensorFlow"],
            ["name" => "PostgreSQL"],
            ["name" => "Angular"],
            ["name" => "ShellScript"],
            ["name" => "centos7"],
            ["name" => "Azure"],
            ["name" => "SQL"],
            ["name" => "lambda"],
            ["name" => "IoT"],
            ["name" => "Django"],
            ["name" => "Ansible"],
            ["name" => "kubernetes"],
            ["name" => "Apache"],
            ["name" => "Windows10"],
            ["name" => "MachineLearning"],
            ["name" => "Firebase"],
            ["name" => "SSH"],
            ["name" => "VirtualBox"],
            ["name" => "Arduino"],
            ["name" => "Excel"],
            ["name" => "iPhone"],
            ["name" => "Haskell"],
            ["name" => "Chrome"],
            ["name" => "Emacs"],
            ["name" => "OpenCV"],
            ["name" => "EC2"],
            ["name" => "VSCode"],
            ["name" => "AndroidStudio"],
            ["name" => "GoogleAppsScript"],
            ["name" => "PowerShell"],
            ["name" => "api"],
            ["name" => "Ksb"],
            ["name" => "Elixir"],
            ["name" => "docker-compose"],
            ["name" => "JSON"],
            ["name" => "homebrew"],
            ["name" => "Toán"],
            ["name" => "oracle"],
            ["name" => "Twitter"],
            ["name" => "GoogleCloudPlatform"],
            ["name" => "npm"],
            ["name" => "Perl"],
            ["name" => "shell"],
            ["name" => "S3"],
            ["name" => "webpack"],
            ["name" => "CSS3"],
            ["name" => "spring-boot"],
            ["name" => "nuxt.js"],
            ["name" => "Slim"],
        ];
        $tag = $this->table("tag");
        $tag->truncate();

        foreach ($data as $d) {
            $d["created_at"] = date("Y-m-d H:i:s");
            $d["updated_at"] = date("Y-m-d H:i:s");
            $tag->insert($d)
                ->save();
        }

    }
}
