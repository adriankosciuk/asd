<?php

namespace Air\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Air\BlogBundle\Entity\Post;


class PostsFixtures extends AbstractFixture implements OrderedFixtureInterface {
    
    public function getOrder() {
        return 1;
    }
    
    public function load(ObjectManager $manager) {
        
        $postsList = array(
            array(
                'title' => 'Lorem ipsum dolor sit amet dignissim',
                'content' => '<p>Vestibulum non ipsum. Curabitur egestas. Integer hendrerit purus consectetuer adipiscing elit. In sodales in, elementum vel, velit. Suspendisse fermentum, metus convallis nec, hendrerit purus lorem, pellentesque consectetuer, augue a quam purus, pharetra varius. In nec massa. Nam dolor non ipsum. Duis lobortis, massa ut porta sapien leo vitae turpis. Duis ante et velit. Suspendisse a arcu. Sed nibh rutrum rhoncus. Morbi vel turpis luctus tellus ante nec enim fringilla et, congue ac, blandit vestibulum tincidunt justo. Nulla congue. Nam pharetra nec, molestie lorem velit ornare dolor dictum sed, congue sit amet ligula. Vivamus euismod. Vestibulum quam. Aliquam adipiscing tortor, a wisi. Suspendisse turpis a dolor. Fusce blandit risus auctor consectetuer. Sed posuere cubilia Curae, Donec pulvinar ut, gravida non, porttitor lectus urna ullamcorper ut, metus. Nulla quis est. Nunc viverra, enim dictum a, mauris. Praesent odio sagittis nibh nulla, faucibus orci ac metus. Curabitur tempor. Suspendisse turpis viverra vel, urna. Cras a dolor. Mauris interdum vitae, vestibulum volutpat, erat ut enim. In quam accumsan id, bibendum porttitor. Aenean egestas dignissim, libero mollis aliquam, nulla facilisis urna eu pede ultrices tortor ante ullamcorper massa placerat at, velit. Mauris convallis ligula accumsan nisl a augue. Donec faucibus scelerisque. Nam turpis et augue. Nulla augue ut arcu. In malesuada velit eleifend ut, ligula. Mauris ut porta tellus ac arcu. Duis ut justo a dolor sit amet tellus sodales pede. Morbi nibh. Morbi risus metus eros sed tortor. In ornare eu, fringilla mi, viverra luctus, enim est eu.</p>',
                'category' => 'osobowe',
                'tags' => array('dolor', 'suspendisse', 'quisque', 'luctus'),
                'author' => 'kowal',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => NULL,
            ),
            array(
                'title' => 'Integer hendrerit purus consectetuer',
                'content' => '<p>Suspendisse fermentum, metus convallis nec, hendrerit purus lorem, pellentesque consectetuer, augue a quam purus, pharetra varius. In nec massa. Nam dolor non ipsum. Duis lobortis, massa ut porta sapien leo vitae turpis. Duis ante et velit. Suspendisse a arcu. Sed nibh rutrum rhoncus. Morbi vel turpis luctus tellus ante nec enim fringilla et, congue ac, blandit vestibulum tincidunt justo. Nulla congue. Nam pharetra nec, molestie lorem velit ornare dolor dictum sed, congue sit amet ligula. Vivamus euismod. Vestibulum quam. Aliquam adipiscing tortor, a wisi. Suspendisse turpis a dolor. Fusce blandit risus auctor consectetuer. Sed posuere cubilia Curae, Donec pulvinar ut, gravida non, porttitor lectus urna ullamcorper ut, metus. Nulla quis est. Nunc viverra, enim dictum a, mauris. Praesent odio sagittis nibh nulla, faucibus orci ac metus. Curabitur tempor. Suspendisse turpis viverra vel, urna. Cras a dolor. Mauris interdum vitae, vestibulum volutpat, erat ut enim. In quam accumsan id, bibendum porttitor. Aenean egestas dignissim, libero mollis aliquam, nulla facilisis urna eu pede ultrices tortor ante ullamcorper massa placerat at, velit. Mauris convallis ligula accumsan nisl a augue. Donec faucibus scelerisque. Nam turpis et augue. Nulla augue ut arcu. In malesuada velit eleifend ut, ligula. Mauris ut porta tellus ac arcu. Duis ut justo a dolor sit amet tellus sodales pede. Morbi nibh. Morbi risus metus eros sed tortor. In ornare eu, fringilla mi, viverra luctus, enim est eu.</p>',
                'category' => 'osobowe',
                'tags' => array('quisque', 'malesuada', 'luctus'),
                'author' => 'kowal',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => '2012-11-04 12:10:11',
            ),
            array(
                'title' => 'Praesent odio sagittis nibh nulla',
                'content' => '<p>Lorem ipsum dolor sit amet purus at adipiscing vitae, vulputate vitae, vestibulum lorem lorem lectus, pellentesque auctor tortor elit a arcu. Etiam sit amet nunc tempus ac, rhoncus ut, magna. Integer tristique magna nec nunc ultrices adipiscing non, posuere in, libero. Nulla facilisi. Nam laoreet hendrerit sagittis. Curabitur ut metus. Aliquam eleifend, ligula. Curabitur nunc. Aliquam ultricies porta. Sed eros. Pellentesque facilisis. Fusce et arcu. In hac habitasse platea dictumst. Vestibulum ante vitae erat libero, consectetuer dignissim, sapien varius quis, velit. Suspendisse fringilla orci. Mauris in vestibulum id, vulputate aliquam id, tortor. Cras id wisi diam, venenatis quis, ornare velit wisi, ullamcorper ligula nunc, rhoncus et, imperdiet aliquam ut, nunc. Sed porta neque. Vestibulum et pede sit amet, ante. Vivamus arcu sed laoreet fermentum. Proin gravida at, egestas vitae, vulputate tellus a dui. Mauris nec tellus. Donec molestie mauris. Donec sit amet eleifend purus laoreet hendrerit nunc ac erat velit odio at sollicitudin orci. Integer condimentum justo non mattis egestas, justo ac turpis nec augue. Donec libero nec lectus elit, ut justo. Donec porta, metus et interdum dui gravida pulvinar eget, velit. Mauris eget luctus aliquam, risus. Sed in dolor. Mauris lobortis vitae, sollicitudin lorem, id mauris ac lacus. Nulla mi odio, in faucibus justo imperdiet quis, vestibulum nec, sagittis tortor quis justo. In hac habitasse platea dictumst. Nunc leo. Sed pharetra. Suspendisse elit. Curabitur sed tortor. Ut turpis. Nam eget imperdiet dignissim, tellus. Integer lacinia eget, pede. Cras luctus diam eros, aliquam vehicula convallis varius. Ut sit amet leo.</p>',
                'category' => 'odrzutowe',
                'tags' => array('maecenas', 'faucibus', 'malesuada', 'suspendisse', 'etiam'),
                'author' => 'kowal',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => '2012-12-23 16:10:11',
            ),
            array(
                'title' => 'Donec sit amet eleifend purus laoreet',
                'content' => '<p>Lorem ipsum dolor sit amet sapien varius in, lobortis augue. Morbi justo. Praesent volutpat aliquam pharetra vel, arcu. Duis pretium bibendum purus est, at arcu mi ipsum sit amet mauris. Etiam tincidunt nec, ullamcorper pellentesque. Praesent dolor. Mauris ac arcu. Duis a purus. Class aptent taciti sociosqu ad litora torquent per inceptos hymenaeos. Sed eros. Quisque ultricies lobortis, massa et ultrices velit, fermentum sed, posuere eu, tempor eros malesuada pretium. Vestibulum ante congue tristique. Donec eu fermentum varius. Morbi quam at sapien. Donec eu cursus wisi, id enim. In et libero. Aliquam eleifend non, quam. Sed at nulla ut lacus et magnis dis parturient montes, nascetur ridiculus mus. Integer auctor eu, urna. Nam nunc ac turpis egestas. Praesent feugiat. Cum sociis natoque penatibus et velit. Praesent sollicitudin, urna quam, ultrices consectetuer. Aliquam risus risus vehicula sed, ornare lacus egestas velit. Pellentesque commodo est ullamcorper convallis. Praesent dictum vel, ornare laoreet. Aenean dictum ut, metus. Aliquam fermentum wisi, eget est ullamcorper augue, vestibulum volutpat, libero dui, dictum aliquet vulputate, enim diam, tincidunt hendrerit nonummy. Phasellus pulvinar sem nunc, ac massa nisl, semper quis, luctus et orci interdum viverra. Cras adipiscing elit. Curabitur quam nunc, tempus nulla. Maecenas wisi. Maecenas nunc. Ut bibendum ac, porta urna. Nam lectus elit, dictum sit amet, tellus. Donec vitae massa. Pellentesque tempus ornare arcu nunc sem, posuere risus. Aliquam dolor lorem, tempus at, accumsan sit amet, mattis lorem tempus ac, sodales nulla. Aliquam tempus at, bibendum mi, porttitor risus. Suspendisse bibendum blandit, quam. Nam ullamcorper in.</p>',
                'category' => 'wojskowe',
                'tags' => array('quisque', 'malesuada', 'dolor', 'suspendisse'),
                'author' => 'antkow',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => '2013-01-05 18:16:11',
            ),
            array(
                'title' => 'Aenean dictum ut, metus',
                'content' => '<p>Curabitur non orci. Phasellus dui turpis at neque. Integer neque vel blandit vestibulum eget, nisl. Vestibulum a diam. Aliquam posuere metus. Nullam dui lectus felis, vestibulum lorem eu tempor nisl sit amet, euismod scelerisque tellus vulputate faucibus. Maecenas nec lectus ut tortor. Donec pede. Vestibulum ante sem ante ipsum primis in est eu odio. Ut bibendum tempus. Pellentesque fringilla orci. Vestibulum ante ipsum dolor tellus malesuada ultricies nulla, accumsan adipiscing, risus risus tortor, a metus. Integer nibh porta tincidunt. Sed sit amet mi odio, a sapien. Morbi vel turpis. Nullam wisi ultricies lacinia eget, bibendum tempus. Quisque porta eget, molestie placerat, nulla quam enim, aliquet ac, eleifend congue. Maecenas vehicula, tortor lacus nec massa vulputate tortor quis turpis at ipsum primis in erat velit et malesuada fames ac felis cursus consequat, orci ultricies feugiat, quam leo, cursus sed, ornare vitae, ornare lacus tincidunt vehicula, feugiat sagittis lectus nulla in volutpat lacinia quam elit porta ac, eleifend viverra. Mauris pretium eget, aliquam enim dictum at, vehicula non, facilisis congue. Mauris suscipit enim. Fusce aliquam cursus mauris non diam. Morbi dui lectus, pellentesque auctor vitae, dolor. Pellentesque nibh orci lorem non ante imperdiet wisi. Nam vestibulum. Nunc id aliquet eget, bibendum eget, eros. Sed gravida mattis, magna dictum suscipit dui eu enim. Etiam ac purus. Nulla facilisi. Etiam ornare arcu nec mauris vehicula faucibus, tortor id lacus. Ut sit amet felis facilisis diam vel lectus. Vestibulum ante ipsum primis in turpis dolor, luctus et neque. Mauris.</p>',
                'category' => 'wojskowe',
                'tags' => array('etiam', 'suspendisse', 'vestibulum', 'luctus'),
                'author' => 'antkow',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => NULL,
            ),
            array(
                'title' => 'Sed gravida mattis magna dictum',
                'content' => '<p>Lorem ipsum dolor sit amet diam magna ac enim non ligula turpis, fermentum diam ac nulla ornare ligula non mattis id, justo. Curabitur urna ullamcorper in, dapibus augue id nibh. Ut lorem. Sed ac quam ut eros ac posuere eu, sagittis eget, nulla. Aenean scelerisque, dui quis consectetuer egestas, dapibus et, enim. Phasellus ultrices, dui vitae sem. Sed dolor. Quisque consectetuer lectus, porta est. Curabitur elit. Quisque nec odio. Class aptent taciti sociosqu ad litora torquent per inceptos hymenaeos. Maecenas arcu luctus et orci ultricies vehicula, enim consectetuer adipiscing elit. Quisque cursus, lacus sit amet, tellus. Donec vitae facilisis vel, consequat lobortis magna sit amet mi at velit et netus et netus et magnis dis parturient montes, nascetur ridiculus mus. Integer faucibus orci luctus elit, dictum arcu. In euismod pulvinar, pede eget sem leo sodales neque ultrices posuere metus. Aliquam at ipsum. Duis eget odio. Morbi mauris viverra venenatis blandit iaculis, purus et malesuada fames ac viverra auctor, ante ipsum sed augue. Fusce porttitor, quam porta auctor. Nam ut mauris quis orci. Nunc justo. Nam non metus in tellus non nibh quis tortor. Nam id nulla pulvinar felis, eleifend placerat. Vivamus ornare, erat in nibh sagittis non, dictum enim. Duis sit amet purus fermentum gravida feugiat nec, velit. Vivamus pede. Curabitur quam at orci sit amet, consectetuer lacus. Aenean pede cursus odio. Donec nec turpis ligula, in aliquam quis, odio. Aenean vel odio. Suspendisse molestie. Vivamus fermentum a, tortor. Etiam at erat. Praesent euismod id, luctus pellentesque. Proin vel nonummy.</p>',
                'category' => 'kosmiczne',
                'tags' => array('ultricies', 'malesuada', 'dolor'),
                'author' => 'macq',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => '2012-01-01 12:00:00',
            ),
            array(
                'title' => 'Suspendisse molestie vivamus fermentum',
                'content' => '<p>Morbi feugiat sit amet, consectetuer tortor. Morbi eleifend pede id odio id leo velit odio est sem, accumsan fringilla neque nibh condimentum justo felis sed eros. Morbi pede. Sed hendrerit vitae, mauris. Ut lorem. Vivamus diam aliquet ipsum. Nam at nulla ac nisl. Nam placerat ante. Pellentesque euismod orci et enim. Etiam dapibus velit. Donec nec tortor. Morbi hendrerit. Donec non enim ac ligula in dui eu mollis nulla a ante ipsum ut nibh. Ut molestie, felis eget elit tincidunt tempus. In purus sem rutrum posuere suscipit faucibus orci luctus diam. Aliquam erat dictum eu, sagittis vel, magna. Quisque urna. Vestibulum ante pretium magna. Nullam eros ipsum, ultricies neque auctor metus. Maecenas eget nulla. Phasellus vestibulum. Nulla convallis nisl. Nulla iaculis ante, cursus molestie. Donec urna arcu massa, dictum est, dapibus vitae, imperdiet sagittis, elit. Pellentesque habitant morbi tristique dapibus, accumsan congue, aliquet tincidunt tempus. In hac habitasse platea dictumst. Aenean urna tortor, fermentum malesuada. Nullam bibendum mauris nec dui. Morbi id nonummy nunc venenatis nisl. Nam ut felis facilisis neque, quis nulla in wisi. Sed malesuada ultricies. Curabitur imperdiet, nisl pellentesque dolor. Vestibulum egestas purus. Pellentesque at urna orci quis mauris. Pellentesque fermentum facilisis. Fusce fringilla vel, eleifend et, tempus dignissim. Phasellus purus. Duis luctus diam tempor posuere, nibh faucibus gravida non, tellus. Aenean augue euismod id, odio. Aliquam eleifend, ligula. Pellentesque placerat. Vivamus ullamcorper varius in, mollis tincidunt, velit in wisi. Nulla vestibulum ac, mattis egestas, nulla massa, dictum.</p>',
                'category' => 'tajne',
                'tags' => array('ullamcorper', 'suspendisse', 'malesuada', 'etiam'),
                'author' => 'macq',
                'createDate' => '2012-01-01 12:12:12',
                'publishedDate' => '2013-05-11 13:10:11',
            ),
        );
        
        foreach ($postsList as $idx => $details) {
            $Post = new Post();
            
            $Post->setTitle($details['title'])
                    ->setContent($details['content'])
                    ->setAuthor($this->getReference('user-'.$details['author']))
                    ->setCreateDate(new \DateTime($details['createDate']));
            
            if(null !== $details['publishedDate']){
                $Post->setPublishedDate(new \DateTime($details['publishedDate']));
            }
            
            $Post->setCategory($this->getReference('category_'.$details['category']));
            
            foreach($details['tags'] as $tagName){
                $Post->addTag($this->getReference('tag_'.$tagName));
            }
            
            $this->addReference('post-'.$idx, $Post);
            
            $manager->persist($Post);
        }
        
        $manager->flush();
    }

}
