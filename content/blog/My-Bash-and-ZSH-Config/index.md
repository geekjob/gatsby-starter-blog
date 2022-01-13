---
title: "My Bash and ZSH Config"
date: "2021-09-07T12:12:12.00Z"
description: "Simple configurations for Bash and ZSH. These settings have been made for themselves. But it can be useful to someone else"
---

Simple configurations for Bash and ZSH. These settings have been made for themselves.
But it can be useful to someone else. You can clone the repository and to further develop its own version.
This set of files can be core for your configuration.



VIM config you can see at this repo <a href="https://github.com/frontdevops/my-vim-config" target="_blank">my-vim-config</a>.

![mybashconfig](https://raw.githubusercontent.com/frontdevops/my-bash-config/master/misc/assets/zsh.jpg)


## Overview

Working with the server through the terminal we are deprived of the comfort of desktop systems.
It is therefore important to set up a bash console yourself as comfortable as possible. But the server may be more than one.
And sometimes you need to go to a different server. So that every time you do not configure the terminal manually,
I have created for themselves a set of basic configurations.

This configuration I use on all my dedicated servers. I recomended to use screen.
Why screen and what is the `.screenrc`? Suppose you want to run a program persistently (even if a terminal window closes, for example).
For that, you might use the nohup command. But what if you want to start a command-line session on one computer and then go home and resume that session?
For something like that, you’ll want to use screen. Screen is also really handy because you can have multiple shells running in one terminal window.

### Features
Install configurations for:
- screen
- bash
- zsh
- git

### Installation
Clone the project to a myshellconfig folder in your home directory:

```bash
$ cd
$ git clone https://github.com/frontdevops/my-bash-config.git
$ ./myshellconfig/install user

#or

$ ./myshellconfig/install user custom_host_name
```

For root user clone the project in your root directory and run:

```bash
$ su
$ cd
$ git clone https://github.com/frontdevops//my-bash-config.git
$ ./myshellconfig/install root

# or

$ ./myshellconfig/install root custom_host_name
```

After installation on your file system will see two links to the files in the directory test:

```bash
.screenrc -> myshellconfig/.screenrc
.gitconfig -> myshellconfig/.gitconfig
```

I did not replace the original .bashrc in your home directory. I add a link to my version to the end of your configuration file. You can see in install script this rows:

```bash
>> ~/.bashrc
```

You can erase all you configs before instalation:

```bash
echo -n > .bashrc
echo -n > .zshrc
```

and after install all configs

Now edit `.gitconfig` or delete this file and create new with your configurations.

WARNING! If you not trust me, don't do it. You can manually edit your .bashrc and set configuration.
Or not to touch anything and leave everything as is. It's your choice.

![geekjob](https://raw.githubusercontent.com/frontdevops/my-bash-config/master/misc/assets/bash.jpg)


## Git prompt with displaying branch
Working with Git and its great branching/merging features is amazing. Constantly switching branches can be confusing though as you have to run git status to see which branch you're currently on. The solution to this is to have your terminal prompt display the current branch.

If you cd to a Git working directory, you will see the current Git branch name displayed in your terminal prompt. When you're not in a Git working directory, your prompt works like normal.

![gj](https://raw.githubusercontent.com/frontdevops/my-bash-config/master/misc/assets/bash-root.jpg)

The new prompt will take effect beginning in your next session. This usually means logging out completely.
To enable it in your current session, you can simply run `. ~/.bashrc` or create new window in screen (Ctrl+A C).


## Updating
Assuming you followed the default installation instructions and cloned this repo to ~/my-bash-config:

```bash
cd ~/my-bash-config gitup
```


## License
My Standard Open Source License
- Free 4 all!
- As it is
- No guarantees that any of this works anymore
- I will not be responsible for your code and do not guarantee that everything works as it should on your server.
- Other in `No license` text

## Feedback and supports
If you have any suggestions, create a pull request.
