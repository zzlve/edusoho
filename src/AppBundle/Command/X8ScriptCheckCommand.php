<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class X8ScriptCheckCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('util:x8-script-check')
            ->setDescription('x8升级脚本校验');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $biz = $this->getContainer()->get('biz');
        $connection = $biz['db'];
        
        // 课程
        $c1 = $connection->fetchColumn("select count(*) from course;");
        $c2 = $connection->fetchColumn("select count(*) from c2_course;");
        $c3 = $connection->fetchColumn("select count(*) from c2_course_set;");
        if ($c1 == $c2 && $c2 == $c3) {
            $output->writeln('<info>课程数据验证通过.</info>');
        } else {
            $output->writeln('<error>课程数据验证不通过.</error>');
        }

        // 试卷
        $c1 = $connection->fetchColumn("select count(*) from testpaper;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper where type='testpaper';");
        if ($c1 == $c2) {
            $output->writeln('<info> 试卷 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 试卷 数据验证不通过.</error>');
        }

        $c1 = $connection->fetchColumn("select count(*) from activity where mediaType = 'testpaper';");
        $c2 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'testpaper');");
        $c3 = $connection->fetchColumn("select count(*) from testpaper_activity;");
        if ($c1 == $c2 && $c2 == $c3) {
            $output->writeln('<info> 试卷活动 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 试卷活动 数据验证不通过.</error>');
        }


        $c1 = $connection->fetchColumn("select count(*) from testpaper_item;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper_item where testId in (select id from c2_testpaper where type='testpaper');");
        if ($c1 == $c2) {
            $output->writeln('<info> 试卷中题目 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 试卷中题目 数据验证不通过.</error>');
        }

        // 作业：
        $c1 = $connection->fetchColumn("select count(*) from homework;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper where type='homework';");
        $c3 = $connection->fetchColumn("select count(*) from activity where mediaType = 'homework';");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'homework');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> 作业 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 作业 数据验证不通过.</error>');
        }

        $c1 = $connection->fetchColumn("select count(*) from homework_item;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper_item where testId in (select id from c2_testpaper where type='homework');");
        if ($c1 == $c2) {
            $output->writeln('<info> 作业中题目 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 作业中题目 数据验证不通过.</error>');
        }

        // 练习：
        $c1 = $connection->fetchColumn("select count(*) from exercise;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper where type='exercise';");
        $c3 = $connection->fetchColumn("select count(*) from activity where mediaType = 'exercise';");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'exercise');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> 练习 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 练习 数据验证不通过.</error>');
        }

        $c1 = $connection->fetchColumn("select count(*) from exercise_item;");
        $c2 = $connection->fetchColumn("select count(*) from c2_testpaper_item where testId in (select id from c2_testpaper where type='exercise');");
        if ($c1 == $c2) {
            $output->writeln('<info> 练习中题目 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 练习中题目 数据验证不通过.</error>');
        }

        // 视频：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='video';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='video';");
        $c3 = $connection->fetchColumn("select count(*) from video_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'video');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> 视频 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 视频 数据验证不通过.</error>');
        }

        // 音频：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='audio';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='audio';");
        $c3 = $connection->fetchColumn("select count(*) from audio_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'audio');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> 音频 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 音频 数据验证不通过.</error>');
        }

        // ppt：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='ppt';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='ppt';");
        $c3 = $connection->fetchColumn("select count(*) from ppt_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'ppt');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> ppt 数据验证通过.</info>');
        } else {
            $output->writeln('<error> ppt 数据验证不通过.</error>');
        }

        // live：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='live';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='live';");
        $c3 = $connection->fetchColumn("select count(*) from live_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'live');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> live 数据验证通过.</info>');
        } else {
            $output->writeln('<error> live 数据验证不通过.</error>');
        }

        // document：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='document';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='doc';");
        $c3 = $connection->fetchColumn("select count(*) from doc_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'doc');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> document 数据验证通过.</info>');
        } else {
            $output->writeln('<error> document 数据验证不通过.</error>');
        }

        // text:
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='text';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='text';");
        $c3 = $connection->fetchColumn("select count(*) from text_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'text');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> text 数据验证通过.</info>');
        } else {
            $output->writeln('<error> text 数据验证不通过.</error>');
        }

        // flash:
        $c1 = $connection->fetchColumn("select count(*) from course_lesson where type='flash';");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType='flash';");
        $c3 = $connection->fetchColumn("select count(*) from flash_activity;");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'flash');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> flash 数据验证通过.</info>');
        } else {
            $output->writeln('<error> flash 数据验证不通过.</error>');
        }

        // download:
        $c1 = $connection->fetchColumn("select count(*) from course_material where source = 'coursematerial';");
        $c2 = $connection->fetchColumn("select count(*) from download_activity;");
        $c3 = $connection->fetchColumn("select count(*) from activity where mediaType='download';");
        $c4 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType = 'download');");
        if ($c1 == $c2 && $c2 == $c3 && $c3 == $c4) {
            $output->writeln('<info> download 数据验证通过.</info>');
        } else {
            $output->writeln('<error> download 数据验证不通过.</error>');
        }

        // 课时：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson;");
        $c2 = $connection->fetchColumn("select count(*) from course_chapter where type = 'lesson';");
        if ($c1 == $c2) {
            $output->writeln('<info> 课时 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 课时 数据验证不通过.</error>');
        }

        // 除去作业、练习、下载的任务：
        $c1 = $connection->fetchColumn("select count(*) from course_lesson;");
        $c2 = $connection->fetchColumn("select count(*) from activity where mediaType not in ('homework', 'exercise', 'download');");
        $c3 = $connection->fetchColumn("select count(*) from course_task where activityId in (select id from activity where mediaType not in ('homework', 'exercise', 'download'));");
        if ($c1 == $c2 && $c2 == $c3) {
            $output->writeln('<info> 除去作业、练习、下载的任务 数据验证通过.</info>');
        } else {
            $output->writeln('<error> 除去作业、练习、下载的任务 数据验证不通过.</error>');
        }

        // task、activity汇总校验：
        $c1 = $connection->fetchColumn("select count(*) from course_task;");
        $c2 = $connection->fetchColumn("select count(*) from activity;");
        if ($c1 == $c2) {
            $output->writeln('<info> task、activity汇总校验 数据验证通过.</info>');
        } else {
            $output->writeln('<error> task、activity汇总校验 数据验证不通过.</error>');
        }
    }
}