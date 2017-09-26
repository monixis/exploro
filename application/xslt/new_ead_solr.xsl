<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" />

    <xsl:template match="/">

<add>
    <xsl:apply-templates select="ead"/>
</add>

     </xsl:template>
    <xsl:template match="ead">
        <xsl:variable name="collectionLink" select="control/recordid/@instanceurl"/>
        <xsl:variable name="collection" select="control/filedesc/titlestmt/titleproper"/>
        <xsl:variable name="genreform" select="archdesc/controlaccess/genreform/part"/>

        <doc>

                        <field name="collectionLink">
                            <xsl:value-of select="control/recordid/@instanceurl"/>
                        </field>

                        <field name="collection">
                            <xsl:value-of select="control/filedesc/titlestmt/titleproper"/>
                        </field>
                <xsl:if test="control/filedesc/publicationstmt/publisher">
                        <field name="publisher">
                            <xsl:value-of select="control/filedesc/publicationstmt/publisher"/>
                        </field>
                </xsl:if>
                <xsl:if test="control/filedesc/publicationstmt/date">
                         <field name="publisheddate">
                             <xsl:value-of select="control/filedesc/publicationstmt/date"/>
                         </field>
                </xsl:if>
                <xsl:if test="control/filedesc/publicationstmt/address/addressline">
                         <field name="publisheraddress">
                             <xsl:value-of select="control/filedesc/publicationstmt/address/addressline"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname">
                         <field name="corpname">
                              <xsl:value-of select="archdesc/did/repository/corpname"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname/address/addressline">
                    <field name="corpaddress">
                        <xsl:value-of select="archdesc/did/repository/corpname/address/addressline"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname/@identifier">
                         <field name="corplink">
                             <xsl:value-of select="archdesc/did/repository/corpname/@identifier"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/origination/@identifier">
                    <field name="originLink">
                        <xsl:value-of select="archdesc/did/origination/@identifier"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/origination/persname">
                    <field name="origination">
                        <xsl:value-of select="archdesc/did/origination/persname/part"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/datesingle">
                         <field name="datesingle">
                             <xsl:value-of select="archdesc/did/unitdatestructured/daterange/datesingle"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/fromdate">
                         <field name="fromdate">
                             <xsl:value-of select="archdesc/did/unitdatestructured/daterange/fromdate"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/todate">
                        <field name="todate">
                            <xsl:value-of select="archdesc/did/unitdatestructured/daterange/todate"/>
                        </field>
                </xsl:if>
                <xsl:if test="archdesc/did/physdescstructured/@physdescstructuredtype">
                    <field name='physdescstructured'>
                        <xsl:value-of select="archdesc/did/physdescstructured/quantity"/>(<xsl:value-of select="archdesc/did/physdescstructured/unittype"/>)
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitid">
                    <field name="unitid">
                        <xsl:value-of select="archdesc/did/unitid"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/accessrestrict">
                    <field name="accessrestrict">
                        <xsl:value-of select="archdesc/accessrestrict"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/userrestrict">
                    <field name="userrestrict">
                        <xsl:value-of select="archdesc/userrestrict"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/controlaccess/genreform">
                    <field name="genreform">
                        <xsl:value-of select="archdesc/controlaccess/genreform/part"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/controlaccess/geogname">
                    <field name="geogname">
                        <xsl:value-of select="archdesc/controlaccess/geogname/part"/>
                    </field>
                    <field name="geogLink">
                    <xsl:value-of select="archdesc/controlaccess/geogname/@identifier"/>
                </field>
                </xsl:if>
            </doc>
            <xsl:for-each select=".//*[@level='recordgrp']">
                 <xsl:variable name="container" select="./did/container"/>
                <xsl:for-each select=".//*[@level='item']">
                    <doc>
                          <field name="collectionLink">
                              <xsl:value-of select="$collectionLink" />
                          </field>
                        <field name="collection">
                            <xsl:value-of select="$collection" />
                        </field>
                        <field name="format">
                            <xsl:value-of select="$genreform" /><xsl:if test="./controlaccess/genreform">,<xsl:value-of select="./controlaccess/genreform"/></xsl:if>
                        </field>
                        <field name="unitid">
                            <xsl:value-of select="$container" />.<xsl:value-of select="./did/unitid"/>
                        </field>
                        <field name="unittitle">
                            <xsl:value-of select="./did/unittitle"/>
                        </field>
                        <xsl:if test="./did/unitdatestructured/datesingle">
                            <field name="datesingle">
                                <xsl:value-of select="./did/unitdatestructured/datesingle"/>
                            </field>
                        </xsl:if>
                        <xsl:if test="./did/unitdatestructured/daterange/fromdate">
                            <field name="daterange">
                                <xsl:value-of select="./did/unitdatestructured/daterange/fromdate"/>-<xsl:value-of select="./did/unitdatestructured/daterange/todate"/>
                            </field>
                        </xsl:if>
                        <xsl:if test="./physdescstructured/dimensions">
                        <field name="dimensions">
                            <xsl:value-of select="./physdescstructured/dimensions"/>
                        </field>
                        </xsl:if>


                        <xsl:if test="./dao">
                            <field name="link">
                                <xsl:value-of select="./dao/@href"/>
                            </field>
                        </xsl:if>
                        <xsl:if test="./userrestrict">
                            <field name="userrestrict">
                                <xsl:value-of select="./userrestrict"/>
                            </field>
                        </xsl:if>
                    </doc>

                </xsl:for-each>

            </xsl:for-each>

    </xsl:template>




<!--    <xsl:template match="C">
      <doc>
          <xsl:apply-templates/>
          <field name="series">
              <xsl:value-of select="preceding::controlnote/p"/>

          </field>
          <field name="collectionLink">
              <xsl:value-of select="preceding::recordid/@instanceurl"/>
          </field>
          <field name="format">
              <xsl:value-of select="preceding::genreform/part"/><xsl:if test="controlaccess/genreform/part">,<xsl:value-of select="controlaccess/genreform/part"/></xsl:if>
          </field>
      </doc>
    </xsl:template>-->
<!--    <xsl:template>

        <xsl:for-each select="/C/@*[.='item']">
        <xsl:apply-templates/>

    </xsl:for-each>

    </xsl:template>-->
   <!-- <xsl:template match="titleproper">

        <field name="collection"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="repository">

        <field name="corpname"> <xsl:value-of select="part"/></field>

    </xsl:template>


    <xsl:template match="date">
        <field name="date"> <xsl:value-of select="."/></field>
    </xsl:template>
    <xsl:template match="publisher">
        <field name="publisher"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitdatestructured">
        <xsl:if test="datesingle">

        <field name="datesingle"> <xsl:value-of select="datesingle"/></field>
        </xsl:if>
        <xsl:if test="daterange/fromdate">

        <field name="fromdate"> <xsl:value-of select="daterange/fromdate"/></field>
        </xsl:if>
        <xsl:if test="daterange/todate">

        <field name="todate"> <xsl:value-of select="daterange/todate"/></field>
        </xsl:if>
    </xsl:template>



    <xsl:template match="profiledesc">
        <field name="profiledesc"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="langusage">
        <field name="langusage"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="recordid">
        <field name="link">
            <xsl:value-of select="@instanceurl"/>
        </field>

        <field name="recordId">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="address">
        <field name="address"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="ref">

    </xsl:template>
    <xsl:template match="languagedeclaration">

    </xsl:template>
    <xsl:template match="maintenancehistory">

    </xsl:template>
    <xsl:template match="agencycode">
        <field name="agencycode"> <xsl:value-of select="."/></field>

    </xsl:template>

    <xsl:template match="physdescstructured">
        <field name="quantity"> <xsl:value-of select="quantity"/></field>
        <field name="unittype"><xsl:value-of select="unittype"/></field>
    </xsl:template>
    <xsl:template match="repository">
        <field name="corpname"> <xsl:value-of select="corpname/part"/></field>
        <field name="corplink"><xsl:value-of select="corpname/@identifier"/></field>
    </xsl:template>
    <xsl:template match="origination">
        <field name="origination"> <xsl:value-of select="persname/part"/></field>
        <field name="originLink"> <xsl:value-of select="@identifier"/></field>
    </xsl:template>
    <xsl:template match="geogname">
        <field name="geogname"> <xsl:value-of select="part"/></field>
        <field name="geogLink"> <xsl:value-of select="@identifier"/></field>
    </xsl:template>
    <xsl:template match="unittitle">
        <field name="unittitle"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitid">
        <field name="collection"><xsl:value-of select="preceding::titleproper"/></field>
        <field name="unitid"> <xsl:value-of select="."/></field>

    </xsl:template>


    <xsl:template match="physdescset">

    </xsl:template>
    <xsl:template match="langmaterial">

    </xsl:template>
    <xsl:template match="physdescstructured">
        <field name="physdesc"> <xsl:value-of select="dimensions"/></field>

    </xsl:template>

    <xsl:template match="container">
        <field name="container"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="agencyname">
        <field name="agencyname"> <xsl:value-of select="."/></field>
    </xsl:template>
    <xsl:template match="dao">

        <field name="link"> <xsl:value-of select="@href"/></field>

    </xsl:template>

    &lt;!&ndash;xsl:template match="archdesc"&ndash;&gt;
    &lt;!&ndash;doc&ndash;&gt;
    <xsl:template match="accessrestrict">
        <field name="accessrestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="userestrict">
        <field name="userestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="scopecontent">
        <field name="scopecontent">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="bioghist">
        <field name="bioghist">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="controlaccess">
&lt;!&ndash;        <field name="persname">
            <xsl:value-of select="persname"/>
        </field>&ndash;&gt;
        <xsl:if test="geogname/part">

        <field name="geogname">
            <xsl:value-of select="geogname/part"/>
        </field>
        </xsl:if>
        <xsl:if test="geogname/@identifier">

        <field name="geogLink">
            <xsl:value-of select="geogname/@identifier"/>
        </field>
        </xsl:if>
        <xsl:if test="subject">
        <field name="subject">
            <xsl:value-of select="subject"/>
        </field>
        </xsl:if>


    </xsl:template>-->

</xsl:stylesheet>

